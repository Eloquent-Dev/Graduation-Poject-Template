<x-layout>
    @section('title','Task Details #JO-'.$jobOrder->id)

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('worker.assignments') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Assignments
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-brand-dark p-5 text-white flex justify-between items-start">
                <div>
                    <span class="bg-white/20 text-white px-2.5 py-1 rounded text-[10px] font-bold uppercase tracking-wider mb-2 inline-block">
                        {{ $jobOrder->complaint?->category?->name ?? 'uncategorized' }}
                    </span>
                    <h2 class="text-xl font-bold leading-tight">{{ $jobOrder->complaint->title }}</h2>
                    <p class="text-gray-300 text-xs mt-1">Job Order #JO-{{ $jobOrder->id }}</p>
                </div>
                @php
                $priorityColors = [
                'high' => 'bg-red-100 text-red-800 border-red-200 animate-pulse',
                'medium' => 'bg-orange-100 text-orange-800 border-orange-200',
                'low' => 'bg-green-100 text-green-800 border-green-200'
                ];
                $pColor = $priorityColors[$jobOrder->priority] ?? 'bg-gray-100 text-gray-800';

                @endphp
                <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $pColor }}">
                    <i class="fa-solid fa-flag mr-1"></i> {{ strtoupper($jobOrder->priority) }}
                </span>
            </div>

            <div class="p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Issue Description</h3>
                <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 text-gray-700 text-sm italic mb-6">
                    "{{ $jobOrder->complaint->description }}"
                </div>
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Site Location</h3>
                <div class="flex items-center gap-3 p-4 bg-gray-50 border border-gray-200 rounded-xl mb-4">
                    <div class="bg-white p-3 rounded-full shadow-sm text-brand-orange">
                        <i class="fa-solid fa-location-dot text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-800">Dispatched Location</p>
                        <p class="text-xs text-gray-500">{{ $jobOrder->complaint->latitude }}, {{ $jobOrder->complaint->longitude }}</p>
                    </div>
                </div>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $jobOrder->complaint->latitude }},{{ $jobOrder->complaint->longitude }}" target="_blank" class="w-full bg-gray-100 hover:bg-gray-200 text-brand-blue font-bold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2 text-sm border border-gray-300 shadow-sm">
                        <i class="fa-solid fa-route"></i> Open in Google Maps
                    </a>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gray-50 px-5 py-3 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-800"><i class="fa-solid fa-users text-brand-blue mr-2"></i> Dispatched Crew</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach ($jobOrder->workers as $crewMember)
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ $crewMember->user->role === 'supervisor' ? 'bg-brand-blue': 'bg-gray-200 text-gray-600' }} text-white flex items-center justify-center font-bold shadow-sm">
                                {{ substr($crewMember->user->name,0,1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">
                                    {{ $crewMember->user->name }}
                                    @if($employee->id === $crewMember->id) <span class="text-[10px] text-brand-orange ml-1">(You)</span> @endif
                                </p>
                                <p class="text-[10px] text-gray-500 uppercase">{{ $crewMember->job_title }}</p>
                            </div>
                        </div>
                        <div class="text-right flex flex-col items-end gap-1">
                            @if($crewMember->user->role === 'supervisor')
                            <span class="text-[12px] font-bold text-brand-blue"><i class="fa-solid fa-star mr-1"></i> Site Lead</span>
                            @endif

                            @php $status = $crewMember->pivot->worker_status; @endphp
                            @if($status === 'in_route')
                                <span class="bg-orange-100 text-orange-800 px-2 py-0.5 rounded text-[10px] font-bold"><i class="fa-solid fa-truck mr-1"></i> In Route</span>
                            @elseif($status === 'on_site')
                                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded text-[10px] font-bold"><i class="fa-solid fa-location-dot mr-1"></i> On Site</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded text-[10px] font-bold"><i class="fa-solid fa-clock mr-1"></i> Off Site</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if(auth()->user()->role === 'supervisor')
            <div class="bg-blue-50 border border-blue-200 p-5 rounded-xl text-center">
                <h3 class="text-sm font-bold text-brand-blue mb-2">Ready to close this ticket?</h3>
                <p class="text-xs text-gray-600 mb-4">As the Site Lead, you are responsible for submitting the final completion report and evidence.</p>
                <a href="{{ route('supervisor.completion.create',$jobOrder->id) }}" class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 bg-brand-blue hover:bg-blue-800 text-white text-sm font-bold rounded-lg transition shadow-sm">
                    <i class="fa-solid fa-file-signature"></i> Create Completion Report
                </a>
            </div>
        @else
            <div class="bg-orange-50 border border-orange-100 p-4 rounded-xl flex items-start gap-3">
                <i class="fa-solid fa-lock text-brand-orange mt-0 5"></i>
                <div>
                    <p class="text-sm font-bold text-gray-800">Task In Progress</p>
                    <p class="text-xs text-gray-600 mt-1">Work completion reports and job status updates can only be submitted by the designated Site Lead (Supervisor).</p>
                </div>
            </div>
        @endif
    </div>
</x-layout>
