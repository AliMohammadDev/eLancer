<div class="form-group">
    <x-form.input type='text' id="name" name="name" label="Category Name" value="{{ $category->name }}" />
</div>

<div class="form-group">
    <x-form.input type='text' id="slug" name="slug" label="Category Slug" value="{{ $category->slug }}" />
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea id="description" name="description" class="form-control">
        {{ old('description', $category->description) }}
        </textarea>
    @error('description')
        <p class="text text-danger">{{ $message }}</p>
        {{-- <p class="text text-danger">{{ $errors->first('description') }}</p> --}}
    @enderror
</div>
<div class="form-group">
    <x-form.select id="parent_id" name="parent_id" label="Parent" :options="$parents->pluck('name', 'id')" :selected="$category->parent_id" />
    {{-- <label for="parent_id">Parent</label>
    <select id="parent_id" name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
        <option value="">No Parent</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" @if ($parent->id == old('parent_id', $category->parent_id)) selected @endif>
                {{ $parent->name }}
            </option>
        @endforeach
    </select>
    @error('parent_id')
        <p class="text text-danger">{{ $message }}</p>
    @enderror --}}
</div>

<div class="form-group">
    <label for="art_file">Art File</label>
    <input type="file" id="art_file" name="art_file" class="form-control @error('art_file') is-invalid @enderror">
    @error('art_file')
        <p class="text text-danger">{{ $message }}</p>
        {{-- <p class="text text-danger">{{ $errors->first('art_file') }}</p> --}}
    @enderror
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Save</button>
</div>
