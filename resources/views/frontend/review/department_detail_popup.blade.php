@if(count($departments)) 
    @foreach($departments as $department)
        <div class="modal-tooltip" id="model_id_{{$department->id}}">
            <div class="modal-body">
                <h4>{{ $department->name }} </h4><hr>
                <p>{{ $department->description }}</p>
            </div>
        </div>
    @endforeach
@endif