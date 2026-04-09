<x-layout>
    @section('title', 'manage Categories')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <div class="mb-8 flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Issue Categories</h1>
                <p class="text-sm text-gray-500 mt-1">Manage the types of complaints citizens are allowed to submit.</p>
            </div>
            <a href="{{route('admin.categories.create')}}"
                class="bg-brand-blue hover:bg-blue-800 text-white font-bold px-5 py-2.5 rounded-xl shadow-sm transition flex items-center gap-2 text-sm w-fit">
                <i class="fa-solid fa-plus"></i> Add New Category
            </a>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold w-16 text-center">ID</th>
                            <th class="p-4 font-bold w-full">Category Name</th>
                            <th class="p-4 font-bold text-center">Total Complaints</th>
                            <th class="p-4 font-bold text-center">Added On</th>
                            <th class="p-4 font-bold text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="p-4 text-center font-bold text-gray-400 text-sm">
                                    #{{ $category->id }}
                                </td>

                                <td class="p-4">
                                    <span class="font-bold text-brand-blue bg-blue-50 px-3 py-1.5 rounded-lg text-sm">
                                        <a class="hover:underline" href="{{route('admin.categories.show',$category->id)}}">{{ $category->name }}</a>
                                    </span>
                                </td>
                                <td class="p-4 text-center">
                                    <div
                                        class="inline-flex items-center justify-center bg-gray-100 text-gray-700 font-bold text-xs h-8 w-8 rounded-full shadow-inner">
                                        {{ $category->complaints_count ?? 0 }}
                                    </div>
                                </td>

                                <td class="p-4 text-center text-sm text-gray-500 font-medium">
                                    {{ $category->created_at->format('M d, Y') }}
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a class="text-gray-400 hover:text-brand-blue transition p-2 bg-gray-50 hover:bg-blue-50 rounded-lg" href="{{ route('admin.categories.edit', $category->id) }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                        <form id="delete-category-form-{{ $category->id }}" action="{{route('admin.categories.destroy',$category->id)}}" method="post" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                data-form-id="delete-category-form-{{ $category->id }}"
                                                data-item-name="{{ $category->name }}"
                                                class="delete-user-btn text-red-500 cursor-pointer hover:text-red-500 transition p-2 bg-gray-50 hover:bg-red-500 hover:text-white rounded-lg">                                            class="text-gray-400 cursor-pointer hover:text-red-500 transition p-2 bg-gray-50 hover:bg-red-50 rounded-lg">
                                            <i class="fa-solid fa-trash-can pointer-events-none"></i>
                                        </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400">
                                    <p class="text-sm font-medium">No categories found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($categories->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>


    <div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="delete-modal-card">
        <div class="p-6 sm:p-8 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6 shadow-inner">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Confirm Deletion</h3>
            <p class="text-gray-500 mb-8 text-sm">
                Are you sure you want to premanently delete <br>
                <span id="delete-items-name" class="font-bold text-lg text-gray-800 bg-gray-100 px-2 py-1 rounded mt-2 inline-block"></span><br><br>
                This action cannot be undone.
            </p>
            <div class="flex justify-center gap-4">
                <button type="button" onclick="closeDeleteModal()" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 transition cursor-pointer w-full shadow-sm">
                    Cancel
                </button>
                <button type="button" id="confirm-delete-btn" class="px-6 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold transition shadow-md cursor-pointer w-full shadow-sm">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    let formToSubmitId= null;
    function openDeleteModal(buttonElement){
        formToSubmitId = buttonElement.getAttribute('data-form-id');
        const itemName = buttonElement.getAttribute('data-item-name');
        document.getElementById('delete-items-name').innerText = itemName;

        const modal = document.getElementById('delete-modal');
        const modalCard = document.getElementById('delete-modal-card');

        modal.classList.remove('hidden');
        modal.classList.add('flex')


        setTimeout(() => {
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        },10);
    }
function closeDeleteModal(){
    const modal = document.getElementById('delete-modal');
    const modalCard = document.getElementById('delete-modal-card');

    modalCard.classList.remove('scale-100');
    modalCard.classList.add('scale-95');

    setTimeout(()=>{
        modal.classList.remove('flex')
        modal.classList.add('hidden');

        formToSubmitId = null;
    },200);
}
document.getElementById('confirm-delete-btn').addEventListener('click',function(){
    if (formToSubmitId){
        document.getElementById(formToSubmitId).submit();
    }
});
document.getElementById('delete-modal').addEventListener('click',function(e){
    if (e.target=== this){
        closeDeleteModal();
    }
    });

</script>
</x-layout>
