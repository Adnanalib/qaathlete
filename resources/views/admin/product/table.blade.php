<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Products</h3>
            </div>
            <div class="panel-body table-responsive">
                <table id="demo-dt-basic" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>UUID</th>
                            <th>Cover Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Category</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->uuid }}</td>
                            <td><img width="100" height="100" src="{{ asset($product->cover_photo) }}" alt="{{ $product->title }}" /></td>
                            <td>{{ $product->title }}</td>
                            <td>{{ str_limit($product->description, 200) }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->discount }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ !empty($product->created_at) ? \Carbon\Carbon::parse($product->created_at)->format('Y-m-d
                                H:i:s') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
