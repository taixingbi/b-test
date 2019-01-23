@extends('layouts.master')

@section('title')
    Admin
@endsection

@section('styles')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

@endsection

@section('content')

    <button type="button" class="btn btn-primary" onclick="window.location='{{ route("admin.monthly") }}'">TIX Agents Monthly Report</button>
    {{--<button type="button" class="btn btn-primary" onclick="window.location='{{ route("admin.report") }}'">Store Partners Report</button>--}}

    <h2>Agent Management</h2>

    <table id="agent" class="display agent" style="width:100%;">
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Change Role</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($agents as $agent)
            @if($agent->modelHasRole->role->name!="admin")
                <tr>
                    <td>{{$agent->first_name}}</td>
                    <td>{{$agent->last_name}}</td>
                    <td>{{$agent->email}}</td>
                    <td>{{$agent->modelHasRole->role->display_name}}</td>
{{--                    <td>{{$agent->roles->role_id}}</td>--}}
{{--                    <td>{{$agent->first_name}}</td>--}}
                    <td>
                        @foreach($roles as $role)
                            <button type="button" id="item" class="btn invBTN
                                @if($role->id==$agent->modelHasRole->role->id)
                                    btn-primary
                                @else
                                    btn-light
                                @endif
                            "
                                    onclick="location.href='/bigbike/admin/update_role/{{$agent->id}}/{{$role->id}}'"
                            >{{$role->display_name}}</button>
                        @endforeach
                    </td>

                    <td>
                        {{--@if(intval($inventory->qty)>0)--}}
                            {{--<input type="text" hidden id="price{{ $inventory->id }}" value="{{ $inventory->price }}">--}}
                            {{--<select id="qty{{ $inventory->id }}" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">--}}
                                {{--@for ($i = 0; $i <= intval($inventory->qty); $i++)--}}
                                    {{--<option value="{{ $i }}" @if($i==0) default @endif>{{ $i }}</option>--}}
                                    {{--<option value="saab">Saab</option>--}}
                                    {{--<option value="opel">Opel</option>--}}
                                    {{--<option value="audi">Audi</option>--}}
                                {{--@endfor--}}
                            {{--</select>--}}
                            {{--<button type="button" id="item{{ $inventory->id }}" class="btn btn-success invBTN" style="background-color: #007bff;">Add to Cart</button>--}}
                        {{--@endif--}}
                        @if(empty($agent->deleted_at))
                            <button type="button" id="item" onclick="location.href='/bigbike/admin/delete/{{$agent->id}}'" class="btn btn-danger invBTN" >Revoke</button>
                        @else
                            <button type="button" id="item" onclick="location.href='/bigbike/admin/restore/{{$agent->id}}'" class="btn btn-success invBTN" >Restore</button>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Change Role</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $('.agent').DataTable( {
            "pagingType": "full_numbers"
        } );

    </script>
@endsection