<div class="card card-default">
    <div class="card-header">Manage Category TreeView</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3>Category List</h3>
                <ul id="tree1">
                    @foreach($categories as $category)
                        <li>
                            {{ $category->name }}
                            @if(count($category->children))
                                @include('tenant.catalog.categories.tree.children',['children' => $category->children])
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                {!! html()->form(route('categories.store'))->open() !!}
                <h3>Add New Category</h3>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {!! html()->label('Title:') !!}
                    {!! html()->text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Enter Title']) !!}
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                </div>

                <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                    {!! html()->label('Category:') !!}
                    {!! html()->select('parent_id',[], old('parent_id'), ['class'=>'form-control', 'placeholder'=>'Select Category']) !!}
                    <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-success">Add New</button>
                </div>
                {!! html()->form()->close() !!}
            </div>
        </div>
    </div>
</div>
