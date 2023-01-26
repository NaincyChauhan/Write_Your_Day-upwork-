<form method="POST" action="{{ route('user.update', $user->id) }}" id="request-form-edit" enctype="multipart/form-data">
    <div class="modal-body">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name" class="">Name<font color="red">*</font> :</label>
                    <input type="text" class="form-control" name="name" placeholder="Name"  value="{{ $user->name }}"> 
                </div>
            </div>
            {{-- <div class="col-md-12">
                <div class="form-group">
                    <label for="phone" class="">Phone<font color="red">*</font> :</label>
                    <input type="number" class="form-control" name="phone" value="{{$user->phone}}" placeholder="Phone" >
                </div>
            </div>  --}}
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email" class="">Email<font color="red">*</font> :</label>
                    <input type="email" class="form-control" name="email" placeholder="Email"   value="{{ $user->email }}">
                </div>
            </div> 
            <div class="col-md-12">
                <div class="form-group">
                    <label for="role_id" class="">Select Role<font color="red">*</font> :</label>
                    <select class="form-control" name="role_id"  >
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}"  @if($user->roles()->exists()) {{ $user->roles()->first()->id == $role->id ? 'selected' : '' }} @endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="form-group">
                    <label for="password" class="">Password :</label>
                    <input type="text" class="form-control" name="password" placeholder="Password"  >
                </div>
            </div> 
        </div>
    </div>
    <div class="modal-footer">
        <button id="request-btn-edit" type="button" type="submit" onclick="$('#request-form-edit').submit()" class="btn btn-primary">
      <i class="mdi mdi-plus-circle-outline"></i> Save
    </button>
    </div>
</form>

<script>
    updateValidation();
</script>