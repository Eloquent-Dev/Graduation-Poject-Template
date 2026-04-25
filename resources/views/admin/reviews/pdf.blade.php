<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>QA Review #JO-{{ $jobOrder->id }}</title>
        <style>
            body{font-family: 'xbriyaz', sans-serif; font-size: 13px; color: #333;line-height: 1.5;}
            .header{text-align: center; margin-bottom: 30px; border-bottom:2px solid #ddd; padding-bottom: 15px;}
            .header h1{margin: 0; color:#111 ; font-size: 24px;}
            .header p{margin: 10px 0 5px 0; color:#333; font-size: 18px;}
            .card{border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin-bottom: 25px; overflow:hidden; page-break-inside:avoid;}
            .card-header{background-color: #f3f4f6; padding: 12px 15px; font-weight: bold;border-bottom: 1px solid #ddd; font-size: 16px; color: #374151;}
            .card-header.blue{background-color:#eff6ff;color:#1e40af;border-bottom: 1px solid #bfdbfe;}

            .card-body{padding: 20px;}

            .badge{display: inline-block; background-color: #eff6ff;color: #1e40af; padding:4px 8px; font-size: 10px; font-weight:bold; text-transform:uppercase; border-radius: 4px; margin-bottom:10px; border: 1px solid #bfdbfe;}

            h4{margin-bottom:10px; font-size:18px; color: #111;}
            .quote{ font-style: italic; color: #111; border-left: 3px solid #cbd5e1; padding-left: 12px; margin: 20px 0;}

            .section-label{font-size:10px;font-weight:bold; text-transform:uppercase; color: #6b7280; margin:15px 0 5px 0;}
            .notes-box{background-color:#f8fafc; border:1px solid #e2e8f0; padding: 12px; border-radius:6px; margin-bottom: 15px; color: #1e293b;}

            .img-container{text-align: center; border:1px solid #e5e7eb; padding: 5px; border-radius:6px; background-color: #fff;}
            .img-container img{max-width: 100%; max-height:250px; border-radius:4px;}
            .no-img {background-color: #f9fafb; border:1px dashed #d1d5db; color: #9ca3af; font-size: 12px; padding:20px; text-align: center; border-radius: 6px;}

            .signature{margin-top: 15px; padding: 12px; background-color: #f0fdf4; border:1px solid #bbf7d0; color: #15803d; font-size: 12px; text-align:center; border-radius:6px;}

            table.meta-table{width: 100%; margin-bottom:15px; font-size: 12px;}
            table.meta-table td{padding: 2px 0;}
            table.meta-table td.right{text-align: right; color: #666;}
        </style>
    </head>
    <body>

        <div class="header">
            <h1>City Voice</h1>
            <p>QA Review: Job Order #JO-{{ $jobOrder->id }}</p>
        </div>

        <div class="card">
            <div class="card-header">
                1. Original Citizen Report
            </div>
            <div class="card-body">
                <table class="meta-table">
                    <tr>
                        <td>
                            <div class="section-label" style="margin-top: 0;">Reported By</div>
                            <strong>{{ $jobOrder->complaint->user->name ?? 'Anonymous Citizen' }}</strong>
                        </td>
                        <td class="right">
                            <div class="section-label" style="margin-top:0;">Submitted At:</div>
                            <strong>{{ $jobOrder->complaint->created_at->format('M d, Y h:i A') }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 10px;">
                            <span class="badge">{{ $jobOrder->complaint->category->name }}</span>
                        </td>
                    </tr>
                </table>

                <h4>{{ $jobOrder->complaint->title }}</h4>
                <div class="quote">{{ $jobOrder->complaint->description }}</div>

                <div class="section-label">Citizen Photo</div>
                @if($jobOrder->complaint->image_path)
                    <div class="img-container">
                        <img src="{{ public_path('storage/' .$jobOrder->complaint->image_path) }}" alt="Citizen Evidence">
                    </div>
                @else
                    <div class="no-img">No image provided by the citizen.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header blue">
                2. Supervisor Completion Report
            </div>
            <div class="card-body">
                <table class="meta-table">
                    <tr>
                        @php
                            $supervisor = $jobOrder->workers->firstWhere('user.role','supervisor');
                        @endphp
                        <td><strong>Assigned Supervisor:</strong>{{ $supervisor->user->name ?? 'N/A' }}</td>
                        <td class="right">
                            <strong>Completed:</strong> {{ $jobOrder->completionReport->completed_at ? $jobOrder->completionReport->completed_at->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                    </tr>
                </table>

                <div class="section-label">Resolution Notes</div>
                <div class="notes-box">
                    {{ $jobOrder->completionReport?->supervisor_comments ?? 'No notes provided' }}
                </div>

                <div class="section-label">Official Evidence</div>
                @if ($jobOrder->completionReport?->image_path)
                    <div class="img-container">
                        <img src="{{ public_path('storage/' . $jobOrder->completionReport->image_path) }}" alt="Completion Evidence">
                    </div>
                @else
                    <div class="no-img">No image provided by the supervisor.</div>
                @endif

                <div class="signature">
                     Accountability Statement Signed & Verified by supervisor
                </div>
            </div>
        </div>
    </body>
</html>
