<div class="max-w-2xl mx-auto bg-white p-16 rounded">
    <form>
        <div class="mb-6">
            <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Type</label>
            <select id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                @error('type') border-red-500 @enderror" wire:model="type">
                @foreach ($types as $type)
                    <option value="{{ $type }}">
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900">Title</label>
            <input type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model.lazy="title" >
        </div>

        <div class="mb-6">
            <label for="body" class="block mb-2 text-sm font-medium text-gray-900">Body</label>
            <input type="text" id="body" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model.lazy="body" >
        </div>

        <div class="mb-6">
            <label for="link" class="block mb-2 text-sm font-medium text-gray-900">Link</label>
            <input type="text" id="link" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" wire:model.lazy="link" >
        </div>

        <div class="mb-6">
            <label for="linkText" class="block mb-2 text-sm font-medium text-gray-900">Link Text</label>
            <input type="text" id="linkText" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="View..." wire:model.lazy="linkText" >
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center" wire:click.prevent="send">Send</button>
    </form>
</div>
