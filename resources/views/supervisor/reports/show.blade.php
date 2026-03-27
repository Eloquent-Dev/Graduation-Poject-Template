<x-layout>
    @section('title', 'Report Details #JO-' . $completionReport->job_order_id)

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('supervisor.reports.index') }}"
            class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to My Reports
        </a>
        <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4">
                <div>
            <h1 class="text-2xl font-bold text-gray-900">Completion Report Details</h1>
            <p class="text-sm text-gray-500 mt-1">Submitted on {{ $completionReport->created_at->format('M d, Y \a\t h:i A') }}</p>
        </div>
        @php $status = $completionReport->jobOrder->status; @endphp
        @if ($status==='under-review')
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-hourglass-half text-lg"></i>
        </div>
        <div>
            <span class="block text-xs font-bold uppercase tracking-wider opacity-80 text-yellow-500">Current Status</span>
            <span class="block font-bold">Pending Admin Review</span>
        </div>
    </div>
@elseif ($status==='approved' || $status === 'resolved')
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-check-double text-lg"></i>
    </div>
    <div>
        <span class="block text-xs font-bold uppercase tracking-wider opacity-80 ">Current Status</span>
        <span class="block font-bold">Officially Approved</span>
    </div>
</div>
@endif
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow_hidden">
    <div class="bg-gray-50 px-6 border-b border-gray-200">
        <div class="flex items-center gap-2 bm-4">
        <i class="fa-solid fa-link text-gray-400"></i>
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Original Job Details</h3>
</div>
<div class="grod drid-cols-1 sm;grid-clos2 gap-4">
    <div>
        <span class="block text-xs text-gray-500 mb-1">Job Order ID</span>
        <span class="block text text-gray-900">#JO-{{ $completionReport->job_order_id }}</span>
</div>
<div>
    <span class="block text-xs text-gray-500 mb-1">Task Category</span>
    <span class="font-bold text-brand-blue">{{ $completionReport->jobOrder->complaint->category->name ?? 'Uncategorized' }}</span>
</div>
<div class="sm:col-span-2">
    <span class="block text-xs text-gray-500 mb-1">Task Description</span>
    <p class="text-sm text-gray-700 bg-white p-3 rounded border border-gray-200"> {{ $completionReport->jobOrder->complaint->title }} -{{ $completionReport->jobOrder->complaint->description }}</p>
</div>
</div>
</div>
<div class="p-6">
    <div class="flex items-center gap-2 mb-4">
        <i class="fa-solid fa-clipboard-check text-brand-blue"></i>
        <h3 class="text-sm font-bold text-brand-blue uppercase tracking-wider"> Your Submitted Evidence</h3>
    </div>
    <div class="mb-6">
        <span class="block text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Resolution Notes</span>
        <p class="bg-blue-50/50 text-gray-800 text-sm p-4 rounded-lg border border-blue-100">{{ $completionReport->supervisor_comments }}</p>
    </div>
</div>
<div class="m-6">
    <span class="block text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Attached Photos</span>
    @if ($completionReport->image_path)
    <img src="{{ asset('storage/' . $completionReport->image_path) }}" class="w-full max-w-2*1 rounded-lg border border-gray-200 shadow-sm object-cover">
    @else
    <div class="bg-gray-50 border-2 border-gray-200 border-dashed rounded-lg p-8 text-center text-gray-400 max-w-2*1">
        <i class="fa-solid fa-camera-slash text-3xl mb-2"></i>
        <p class="text-sm">No images attached</p>
    </div>
    @endif
</div>
</div>
</div>
</div>
</x-layout>
