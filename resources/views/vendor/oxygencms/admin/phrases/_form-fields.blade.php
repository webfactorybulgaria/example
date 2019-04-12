<div class="row">
    <!-- group -->
    {{--<div class="form-group col-3">--}}
        {{--<label for="group">Group <strong>*</strong></label>--}}
        {{--<input type="text"--}}
               {{--class="form-control {{ $errors->has('group') ? 'is-invalid' : null }}"--}}
               {{--id="group"--}}
               {{--name="group"--}}
               {{--placeholder="Enter phrase group..."--}}
               {{--value="{{ old('group', optional($phrase)->group) ?: 'db' }}"--}}
        {{-->--}}
        {{--{!! $errors->first('group', '<small class="form-text text-danger">:message</small>') !!}--}}
    {{--</div>--}}
    <div class="form-group col-3">
        <label for="group">Group <strong>*</strong></label>
        <select class="form-control"
                id="group"
                name="group"
        >
            @foreach(config('phrases.groups') as $group)
                <option value="{{ $group }}"
                        {{ $group == old('group', optional($phrase)->group) ? 'selected' : null }}
                >
                    {{ $group }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('group', '<small class="form-text text-danger">:message</small>') !!}
    </div>

    <!-- key -->
    <div class="form-group col-3">
        <label for="key">Key <strong>*</strong></label>
        <input type="text"
               class="form-control {{ $errors->has('key') ? 'is-invalid' : null }}"
               id="key"
               name="key"
               placeholder="Enter phrase key..."
               value="{{ old('key', optional($phrase)->key)}}"
        >
        {!! $errors->first('key', '<small class="form-text text-danger">:message</small>') !!}
    </div>
</div>

@foreach(config('oxygen.locales') as $locale => $locale_name)
    <div class="row">
        <!-- text -->
        <div class="form-group col-6">
            <label for="{{ "text-$locale" }}">Text ({{ $locale }})</label>
            <input type="text"
                   class="form-control {{ $errors->has("text.$locale") ? 'is-invalid' : null }}"
                   id="{{ "text-$locale" }}"
                   name="{{ "text[$locale]" }}"
                   placeholder="Enter phrase text..."
                   value="{{ old("text.$locale", optional($phrase)->getTranslation('text', $locale)) }}"
            >
            {!! $errors->first("text.$locale", '<small class="form-text text-danger">:message</small>') !!}
        </div>
    </div>
@endforeach