<form method="POST" action="{{ route('banner.update',$banner->id) }}" id="updatebannerForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Title:</label>
                    <input type="text" class="form-control" placeholder="Title" name="title" value="{{$banner->title}}"> @if($errors->has('title'))
                    <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                        <strong>{{ $errors->first('title') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Sub Title:</label>
                    <input type="text" class="form-control" placeholder="Sub Title" name="sub_title" value="{{$banner->sub_title}}"> @if($errors->has('sub_title'))
                    <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                        <strong>{{ $errors->first('sub_title') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Btn Name:</label>
                    <input type="text" class="form-control" placeholder="Btn Name" name="btn_name" value="{{ $banner->btn_name}}"> @if($errors->has('btn_name'))
                    <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                        <strong>{{ $errors->first('btn_name') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">Btn Url:</label>
                    <input type="text" class="form-control" placeholder="Btn Url " name="url" value="{{$banner->url}}"> @if($errors->has('url'))
                    <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                        <strong>{{ $errors->first('url') }}</strong>
                    </p>
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Image<font color="red">*</font>  : </label>            
            <input type="file" id="categoryimage" name="image" value="{{ old('image') }}" accept="image/*" class="file-upload-default">
            <div class="input-group col-xs-12">
                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                <span class="input-group-append">
                    <label for="categoryimage" id="categoryimagelable"  class="file-upload-browse btn btn-primary" type="button">Upload</label>
                </span>
            </div>
            @if (isset($banner->image))
            <img class="rounded mt-2" src="{{ asset('storage/banners/'.$banner->image) }}" alt="{{ $banner->title }}" style="width: 100px">
            @endif
            @if($errors->has('image'))
            <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                <strong>{{ $errors->first('image') }}</strong>
            </p>
            @endif
        </div>
        <div class="form-group">
            <label for="desc" class="form-label">Descipation:</label>
            <textarea class="form-control" placeholder="Descripation"  name="desc" id="desc" rows="4"  value="{{ $banner->desc}}">{{$banner->desc}}</textarea>
            @if($errors->has('desc'))
            <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                <strong>{{ $errors->first('desc') }}</strong>
            </p>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <button id="updatebannerBTN" type="submit" class="btn btn-primary">
            <i class="mdi mdi-cloud-upload"></i> Save
        </button>
    </div>
</form>

<script>
    updateValidation();
</script>