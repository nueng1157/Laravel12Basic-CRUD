@extends('home')

@section('css_before')
@endsection

@section('header')
@endsection

@section('sidebarMenu')
@endsection

@section('content')

<div class="container mt-4">
    <div class="row">
    <div class="col-md-10">
<h3> Admin Data  
<a  href="/admin/adding" class="btn btn-primary btn-sm mb-2"> + AdminData </a>
</h3>


<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr class="table-info">
            <th width="5%" class="text-center">No.</th>
            <th width="50%">ชื่อ-สกุล</th>
            <th width="30%">Username</th>
            <th width="5%">edit</th>
            <th width="5%">Pwd</th>
            <th width="5%">delete</th>
        </tr>
    </thead>

    <tbody>
        @foreach($List as $row)
        <tr>
            <td align="center"> {{ $loop->iteration }}.  <!--เรียงลำดับใหม่  --></td>
            <td>{{ $row->admin_name }}  </td>
             <td>{{ $row->admin_username }}  </td>
            <td>
                    <a href="/admin/{{ $row->id }}" class="btn btn-warning btn-sm">Edit</a>
            </td>
            <td>
                    <a href="/admin/reset/{{ $row->id }}" class="btn btn-warning btn-sm">Reset</a>
            </td>
            <td>
                
                 <button type="button" class="btn btn-danger btn-sm" onclick="deleteConfirm({{ $row->id }})">delete</button>

                        <form id="delete-form-{{ $row->id }}" action="/admin/remove/{{$row->id}}" method="POST" style="display: none;">
                            @csrf
                            @method('delete')
                        </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

<p> Add column phone, email, age </p>

<div>
        {{ $List->links() }}
    </div>
    
</div>
</div>
</div>
{{-- devbanban.com  --}}

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection

@section('js_before')
@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function deleteConfirm(id) {
    Swal.fire({
        title: 'คุณต้องการลบ Admin คนนี้หรือไม่?',
        text: "หากลบแล้วจะไม่สามารถกู้คืนได้!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>



