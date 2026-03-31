<x-layout>
    @section('title', 'Add New Category')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.categories.index') }}"class="w-10 h-10 bg-white border-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-brand-blue hover:shadow-sm transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add New Category</h1>
                <p class="text-sm text-gray-500 mt-1">Create a new issue category for citizens to select.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden p-6 md:p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Category Name
                        (Arabic)</label>
                    <input type="text" name="name" id="name required"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-brand-blue
                        focus:border-brand-blue transition outline-none" placeholder="افراد-منازل/إحداث روائح..."
                        value="{{ old('name') }}" dir="rtl">
                    @error('name')
                        <p class="text-red-500 text-xs font-bold mt-2"><i
                                class="fa-solid fa-circle-exclamation"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-6 py-2.5 rounded-lg font-bold text-gray-600 hover:bg-gray-100 transition">
                        Cancel
                    </a>
                    <button type="submit"
                        class="bg-brand-blue hover:bg-blue-800 text-white font-bold px-6 py-2.5 rounded-lg shadow-sm transition flex items-center gap-2">
                        <i class="fa-solid fa-save"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
