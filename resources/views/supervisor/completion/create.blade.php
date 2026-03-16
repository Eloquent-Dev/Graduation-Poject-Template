<x-layout>
    @section('title','Completion Report #JO-'.$jobOrder->id)

    <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8 py-8 w-full">
        <a href="{{ route('worker.assignments.show',$jobOrder->id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-brand-blue font-medium text-sm mb-6 transition">
            <i class="fa-solid fa-arrow-left mr-1"></i> Back to Task Details
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-brand-dark p-5 text-white">
                <div class="flex items-center gap-2 mb-1 text-blue-200 text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-clipboard-check"></i> Final Completion Report
                </div>
                <h2 class="text-xl font-bold leading-tight">Job Order #JO-{{ $jobOrder->id }}</h2>
                <p class="text-gray-300 text-sm mt-1 truncate">{{ $jobOrder->complaint->title }}</p>
            </div>

            <form action="{{ route('supervisor.completion.store',$jobOrder->id) }}" method="post" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg flex items-start gap-3 mb-6">
                    <i class="fa-solid fa-circle-info text-brand-blue mt-0 5"></i>
                    <div>
                        <p class="text-sm font-bold text-gray-800">Quality Assurance Notice</p>
                        <p class="text-xs text-gray-600 mt-1">Submitting this form will send the Job Order to the Administration for review.</p>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="supervisor_comments" class="block font-bold text-sm text-gray-700 mb-2">
                        Resolution Notes <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Detail exactly what the crew did to resolve this issue.</p>
                    <textarea
                    name="supervisor_comments"
                    id="supervisor_comments"
                    rows="6"
                    class="w-full p-4 rounded-lg border-gray-300 shadow-sm focus:border-brand-blue focus:ring-brand-blue text-sm"
                    placeholder="e.g., Replaced 3 meters of damaged PVC pipe and secured the surrounding earth..."
                    required>{{ old('supervisor_comments') }}</textarea>

                    @error('supervisor_comments')
                    <p class="text-red text-sm mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="completion_image" class="block text-sm font-bold text-gray-700 mb-2">
                        "After" Photo (Optional)
                    </label>
                    <p class="text-xs text-gray-500 mb-2">Upload or take a photo proving the work is completed.</p>

                    <input
                    type="file"
                    name="completion_image"
                    id="completion_image"
                    accept="image/*"
                    capture="environment"
                    class="block w-auto cursor-pointer text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition @error('completion_image') border-red-500 @enderror"
                    >

                    @error('completion_image')
                        <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8 rounded-r-lg shadow-sm">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <i class="fa-solid fa-triangle-exclamation text-red-500 mt-0 5 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800 uppercase tracking-wider">Supervisor Accountability Statement</h3>
                            <p class="text-xs text-red-700 mt-1 mb-3 leading-relaxed">
                                As the designated Site Lead, you are officially certifying that the information provided in this report, including all notes and attached media, is accurate and truthful. Falsifying completion reports or misrepresenting the status of work is a strict violation of policy and subject to administrative action.
                            </p>
                            <label class="flex items-center pointer bg-white p-2 rounded border border-red-200 shadow-sm hover:bg-red-100 transition">
                                <input
                                type="checkbox"
                                name="accountability_check"
                                required
                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded pointer">

                                <span class="ml-2 block text-sm font-bold text-red-900">
                                    I certify that the work is completed exactly as stated above.
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end border-t border-gray-100 pt-5">
                    <button type="submit" class="w-full pointer sm:w-auto px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg shadow-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Submit for Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
