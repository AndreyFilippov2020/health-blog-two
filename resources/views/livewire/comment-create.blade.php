<div>
    <div x-data="{
            focused: {{ $parentComment ? 'true' : 'false' }},
            isEdit: {{ $commentModel ? 'true' : 'false'}},
            init() {
                if (this.isEdit || this.focused)
                    this.$refs.input.focus();

                $wire.on('commentCreated', () => {
                    this.focused = false;
                     this.$refs.input.value = '';
                })

                 $wire.on('cancelEditing', () => {
                    this.focused = false;
                    this.isEdit = false;
                     this.$refs.input.value = '';
                })
            }
    }" class="mb-4 mt-10" >

        <div class="mb-2">
            <textarea x-ref="input" wire:model.live="comment" @click="focused = true"
                      class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-theme-color sm:text-sm sm:leading-6"
                      :rows="isEdit || focused ? '2' : '1'"
                      placeholder="Leave a comment"></textarea>
        </div>
        <div :class="isEdit || focused ? '' : 'hidden'">
            <button wire:click="createComment" type="submit"
                    class="rounded-md bg-theme-color px-3.5 py-2.5 mr-4 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-900/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                Submit
            </button>
            <button @click="$wire.dispatch('cancelEditing')" type="button" class="rounded-md bg-gray-100 px-3.5 py-2.5 ext-center text-sm shadow-sm hover:bg-gray-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Cancel
            </button>
        </div>
    </div>
</div>

