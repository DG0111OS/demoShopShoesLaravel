@extends('admin_.layouts.layout_master')
@section('content')
    <div class="col-lg-12 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div>
                        <h3>Product</h3>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th> Name</th>
                            <th> Price</th>
                            <th> Quantity</th>
                            <th> Category</th>
                            <th> Images</th>
                            <th> Create at</th>
                            <th> Size</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($pro) && $pro->count())
                            @foreach($pro as $value)
                                <tr>
                                    <td style="font-size: 12px"> {{$value->name}} </td>
                                    <td style="font-size: 12px"> VNĐ {{number_format($value->price, 0, '', ',')}} </td>
                                    <td style="font-size: 12px"> {{$value->quantity}} </td>
                                    <td style="font-size: 12px"> {{$value->categories->name}} </td>
                                    {{--                        Định nghĩa relationships--}}
                                    <td><img style="width: 100px;height: 100px;border-radius: 0;"
                                             src="{{asset('files/'.$value->image->url)}}"></td>
                                    {{--                                    quan hệ 1 nhiều :(--}}
                                    {{--                        Định nghĩa relationships--}}
                                    <td style="font-size: 12px"> {{$value->created_at}} </td>
                                    <td>
                                        <select>
                                            @foreach($value->sizes as $size)
                                                <option value="">{{$size->size}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="font-size: 12px">
                                        @if(number_format($value->quantity) <= 0)
                                            <label class="badge badge-danger">Hết Hàng</label>
                                        @else
                                            <label class="badge badge-success">Còn Hàng</label>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row mt-1">
                                            <a style="font-size: 12px" href="{{url('admin/product/'.$value->id.'/edit')}}" class="btn btn-warning">Edit</a>
                                        </div>
                                        <div class="row mt-1">
                                            <form class="delete" action="{{ url('admin/product/'.$value->id) }}"
                                                  method="post">
                                                <input
                                                    style="font-size: 12px"
                                                    id="delete"
                                                    class="btn btn-default btn-danger"
                                                    type="submit"
                                                    onclick="deleteProduct()"
                                                    value="Delete"/>
                                                @method('delete')
                                                @csrf
                                            </form>
                                        </div>
                                        <div class="row mt-1">
                                            <a style="font-size: 12px" href="{{route('detailProduct',$value->slug)}}" class="btn btn-facebook">View</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">KHÔNG CÓ SẢN PHẨM NÀO</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>

                <div class="row mt-5">
                    {!! $pro->appends(Request::all())->links() !!}
                </div>
            </div>
        </div>

    </div>
@stop

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>

        @if (Session::get('data'))
        Swal.fire('{{Session::get('data')}}');
        @endif


        function deleteProduct() {
            event.preventDefault();
            var form = event.target.form;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                closeOnConfirm: false
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            })
        }
    </script>
@stop
