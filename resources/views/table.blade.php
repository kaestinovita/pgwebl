@extends ('layout.template')

@section('content')
    <table class="table table-striped">
        <head>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </head>
        <tbody>
            @foreach ($points as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->description }}</td>
                    <td><img src="{{asset('storage/images/'.$p->image)}}" alt="" width="100" tittle="{{$p->image}}"></td>
                    <td>{{ $p->created_at }}</td>
                    <td>{{ $p->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
