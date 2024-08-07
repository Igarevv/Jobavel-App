<div class="container pt-2 font-12">
    @forelse($skillSet as $chunk)
        <div class="row justify-content-around gx-1">
            @foreach($chunk as $key => $skills)
                <div class="col col-lg-1">
                    <span class="fw-bold">{{ $key }}</span>
                    <ul class="list-unstyled overflow-auto mh-90">
                        @foreach($skills as $skill)
                            <li>
                                <label class="category-label-column" for="{{ $skill->id }}">
                                    <input type="checkbox" name="{{ $name }}[]" value="{{ $skill->id }}"
                                           id="{{ $skill->id }}" @checked($isChecked($skill->id, old($name, [])))>
                                    <span>{{ $skill->skillName }}</span>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @empty
        <p class="text-center h6 text-danger fw-bold">Skills set not found, please contact to support</p>
    @endforelse
</div>

