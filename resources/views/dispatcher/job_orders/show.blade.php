<x-layout>
    @section('title', 'Dispatch Job Order #JO-'.$jobOrder->id)
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
        <a href="{{ route('dispatcher.job_orders.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Orders Queue
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-2xl font-bold text-brand-dark mb-1">Work Order #JO-{{ $jobOrder->id }}</h2>
                                <p class="text-xs text-gray-500">Linked to Complaint #{{ $jobOrder->complaint->id }} • Priority: <span class="font-bold text-gray-800 uppercase">{{ $jobOrder->priority }}</span></p>
                            </div>
                            <span class="bg-white text-gray-600 px-3 py-1 rounded text-xs font-bold border border-gray-200 shadow-sm">
                                <i class="fa-solid fa-tag text-brand-orange mr-1"></i> {{ $jobOrder->complaint->category->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Original Complaint Details</h4>
                        <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100 shadow-sm mb-6">
                            <p class="font-bold text-gray-800 mb-2">{{ $jobOrder->complaint->title }}</p>
                            <p class="text-gray-700 text-sm italic border-l-4 border-brand-blue pl-3 py-1">
                                "{{ $jobOrder->complaint->description }}"
                            </p>
                        </div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Target Location</h4>
                        <div id="readonly-map" class="w-full h-80 rounded-t-xl border-2 border-b-0 border-gray-200 shadow-inner"></div>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $jobOrder->complaint->latitude }},{{ $jobOrder->complaint->longitude }}"
                            target="_blank"
                            class="w-full bg-gray-50 hover:bg-gray-100 text-brand-blue font-bold py-3 px-4 rounded-b-xl transition flex items-center justify-center gap-2 text-sm border-2 border-gray-200 pointer shadow-sm">
                            <i class="fa-solid fa-route text-brand-orange"></i> Get Directions to Site
                        </a>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-t-brand-orange">
                    <h3 class="text-sm font-bold text-brand-dark mb-4"><i class="fa-solid fa-users-gear mr-2 text-brand-orange"></i> Assign Field Team</h3>

                    <form action="{{ route('dispatcher.job_orders.update',$jobOrder->id) }}" method="post" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 border-b pb-1">Assign Supervisor(s)</label>
                            <div class="max-h-60 overflow-y-auto space-y-2 pr-2">
                                @forelse ($supervisors as $supervisor)
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg pointer hover:bg-blue-50 transition group">
                                        <input type="checkbox" name="supervisor_ids[]" value="{{ $supervisor->id }}"
                                        class="w-4 h-4 text-brand-blue border-gray-300 rounded focus:ring-brand-blue"
                                        {{ $jobOrder->workers->contains($supervisor->id) ? 'checked' : '' }}>
                                        <div class="ml-3 flex flex-col">
                                            <span class="text-sm font-bold text-gray-800 group-hover:text-brand-blue">{{ $supervisor->user->name }}</span>
                                            <span class="text-[10px] text-gray-500 uppercase">{{ $supervisor->job_title }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <div class="p-4 bg-red-50 text-red-600 text-xs rounded-lg border border-red-100 text-center">
                                        <i class="fa-solid fa-trangle-exclamation mr-1"></i> No supervisors available in this division.
                                    </div>
                                @endforelse
                            </div>
                            @error('supervisor_ids') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-2 border-b pb-1">Assign worker(s)</label>

                            <div class="max-h-48 overflow-y-auto space-y-2 pr-2">
                                @forelse ($workers as $worker)
                                    <label class="flex items-center p-3 border border-gray-200 rounded-lg pointer hover:bg-gray-50 transition group">
                                        <input type="checkbox" name="worker_ids[]" value="{{ $worker->id }}"
                                        class="w-4 h-4 text-brand-orange border-gray-300 rounded focus:ring-brand-orange"
                                        {{ $jobOrder->workers->contains($worker->id) ? 'checked' : '' }}>

                                        <div class="ml-3 flex flex-col">
                                            <span class="text-sm font-bold text-gray-800">{{ $worker->user->name }}</span>
                                            <span class="text-[10px] text-gray-500 uppercase">{{ $worker->job_title }}</span>
                                        </div>
                                    </label>
                                @empty
                                    <div class="p-3 bg-red-50 text-red-600 text-xs rounded-lg border border-red-100 text-center">
                                        <i class="fa-solid fa-trangle-exclamation mr-1"></i> No workers available in this division.
                                    </div>
                                @endforelse
                            </div>
                            @error('worker_ids') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-brand-orange hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition text-sm shadow flex items-center justify-center gap-2 pointer">
                            <i class="fa-solid fa-satellite-dish"></i> Dispatch Team
                        </button>
                    </form>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-t-brand-orange">
                    <h4 class="text-sm font-bold text-gray-800 mb-3"><i class="fa-solid fa-camera mr-2 text-brand-orange"></i> Attached Evidence</h4>

                    @if ($jobOrder->complaint->image_path)
                        <img src="{{ asset('storage/'.$jobOrder->complaint->image_path) }}" alt="Attached evidence for complaint #{{ $jobOrder->complaint->id }}" class="w-full  object-cover rounded-lg border border-gray-200 shadow-sm">
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-8 text-center text-gray-500">
                            <i class="fa-solid fa-image-slash text-3xl mb-2 text-gray-400"></i>
                            <p class="text-sm font-medium">No photo evidence available.</p>
                        </div>
                    @endif
                </div>
                <div id="urgency-card" class="mb-8 border {{ $jobOrder->is_urgent ? 'bg-red-50 border-red-300' : 'bg-white border-gray-200' }} p-5 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between shadow-sm gap-4 transition-colors duration-300">
                    <div>
                        <h4 class="font-bold {{ $jobOrder->is_urgent ? 'text-red-900' : 'text-gray-900' }}" id="urgency-title"><i class="fa-solid fa-triangle-exclamation mr-2 {{ $jobOrder->is_urgent ? 'text-red-500' : 'text-gray-400' }}" id="urgency-icon"></i> Triage & Urgency Assessment</h4>
                        <p class="text-sm {{ $jobOrder->is_urgent ? 'text-red-700' : 'text-gray-500' }} mt-1" id="urgency-desc">Review the citizen's description and evidence. Does this require emergency response?</p>
                    </div>
                    <label class="relative inline-flex items-center pointer shrink-0">
                        <input type="checkbox" id="urgency-toggle" class="sr-only peer" onchange="toggleUrgency({{ $jobOrder->id }}, this)" {{ $jobOrder->is_urgent ? 'checked': '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-500"></div>
                        <span id="urgency-label" class="ml-3 text-sm font-bold {{ $jobOrder->is_urgent ? 'text-red-700' : 'text-gray-600' }}">
                            {{ $jobOrder->is_urgent ? 'Urgent Priority' : 'Normal Priority' }}
                        </span>
                    </label>
                </div>

                <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>
            </div>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps_key') }}&callback=initReadonlyMap&loading=async" async defer></script>
    <script>
        function initReadonlyMap(){
            const location = {
                lat: {{ $jobOrder->complaint->latitude }},
                lng: {{ $jobOrder->complaint->longitude }}
            };

            const map = new google.maps.Map(document.getElementById("readonly-map"),{
                zoom:16,
                center:location,
                streetViewControl:false,
                mapTypeControl:false,
                gestureHandling:"none",
                zoomControl:false
            });

            new google.maps.Marker({
                position: location,
                map: map,
                animation: google.maps.Animation.DROP,
            });
        }

        async function toggleUrgency(complaintId, checkbox){
            const isUrgent = checkbox.checked ? 1 : 0

            const card = document.getElementById('urgency-card');
            const label = document.getElementById('urgency-label');
            const icon = document.getElementById('urgency-icon');
            const title = document.getElementById('urgency-title');
            const desc = document.getElementById('urgency-desc');

            checkbox.disabled = true;

            try{
                const response = await fetch(`/dispatcher/job-orders/${complaintId}/urgency`,{
                    method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    is_urgent: isUrgent
                })
            });
            if(!response.ok) {
                    const errorHTML = await response.text()
                    consle.error("Laravel Server Error:", errorHTML)
                    throw new Error(`HTTP Error: ${response.status}`)
                }

            const data = await response.json()
            checkbox.disabled = false

            if(data.success){

                    if(isUrgent){
                        card.classList.remove('bg-white','border-gray-200')
                        card.classList.add('bg-red-50','border-red-300')

                        label.classList.remove('text-gray-600')
                        label.classList.add('text-red-700')
                        label.innerText = 'Urgent Priority'

                        icon.classList.remove('text-gray-900')
                        icon.classList.add('text-red-500')

                        title.classList.remove('text-gray-900')
                        title.classList.add('text-red-900')

                        desc.classList.remove('text-gray-500')
                        desc.classList.add('text-red-700')
                    }
                    else{
                        card.classList.remove('bg-red-50','border-red-300')
                        card.classList.add('bg-white','border-gray-200')

                        label.classList.remove('text-red-700')
                        label.classList.add('text-gray-600')
                        label.innerText = 'Not Urgent'

                        icon.classList.remove('text-red-500')
                        icon.classList.add('text-gray-900')

                        desc.classList.remove('text-red-700')
                        desc.classList.add('text-gray-500')
                    }

                    showToast('Urgency Updated', 'Urgency status has been updated successfully.', 'success')
                }
        } catch(error){
                checkbox.disabled = false
                checkbox.checked = !isUrgent

                console.error("Javascript Caught Errors", error)

                showToast('Urgency Update Failed', 'There was an error updating the urgency status. Please try again.', 'error')
            }
        }

        function showToast(title, message, type){
            const container = document.getElementById('toast-container');
            const bgColor = type === 'success' ? 'bg-green-600' : 'bg-red-600';
            const icon = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';
            const toast = document.createElement('div');
            toast.className = `flex items-center w-full max-w-xs p-4 text-white ${bgColor} rounded-lg shadow-lg transform transition-all duration-300 translate-y-10 opacity-0`;
            toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg bg-white/20">
                <i class="fa-solid ${icon}"></i>
            </div>
            <div class="ml-3 text-sm font-normal">
                <span class="mb-1 text-sm font-bold text-white block">${title}</span>
                <div class="text-xs text-white/90">${message}</div>
            </div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-x-10');
                setTimeout(() => toast.remove(), 300)
            }, 3000);
        }
    </script>
</x-layout>
