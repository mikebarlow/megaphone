<div>
    <form>
        <div class="card-wrapper rounded-t-none">
            <div class="card-body">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="type" class="label">Type</label>
                        <select id="type" class="w-full block form-element form-select
                        @error('type') border-red-500 @enderror" wire:model="type">
                            @foreach ($types as $type)
                                <option value="{{ $type }}">
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="title" class="label">Title</label>
                        <input id="title" name="title" type="text"
                               class="form-element form-input @error('title') border-red-500 @enderror"
                               wire:model.lazy="title" />

                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="body" class="label">Body</label>
                        <input id="body" name="body" type="text"
                               class="form-element form-input @error('body') border-red-500 @enderror"
                               wire:model.lazy="body" />

                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="link" class="label">Link</label>
                        <input id="link" name="link" type="text"
                               class="form-element form-input @error('link') border-red-500 @enderror"
                               wire:model.lazy="link" />

                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="linkText" class="label">Link Text</label>
                        <input id="linkText" name="linkText" type="text"
                               class="form-element form-input @error('linkText') border-red-500 @enderror"
                               placeholder="View..."
                               wire:model.lazy="linkText" />

                    </div>

                    <div class="col-span-12 sm:col-span-6">
                        <label for="recipients" class="label">Recipients</label>
                        <select id="recipients" class="w-full block form-element form-select
                        @error('recipients') border-red-500 @enderror" wire:model="recipients" multiple>

                        </select>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-md btn-primary btn-shadow" wire:click.prevent="send">Send</button>
            </div>
        </div>
    </form>
</div>
