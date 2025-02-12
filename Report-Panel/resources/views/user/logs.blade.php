@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="container">
        <div class="my-3 my-md-5">
            <div class="container-fluied">
                <!-- start container section -->

                <div class="col-12">
                    <div class="card p-2">
                        <div class="card-header">
                            <h3 class="card-title">User Logs
                            </h3>
                            <div class="card-options">
                                {{-- <form class="form-inline" action="msisdn-list">
                                    <div class="form-group mr-3" style="margin:0px;">
                                        <label class="mr-1">Operator :</label>
                                        <select class="form-control" name="opr">
                                            <option value="airtel">Airtel</option>
                                            <option value="blink">Blink</option>
                                            <option value="GP">GP</option>
                                            <option value="Ooredoo">Ooredoo</option>
                                            <option value="robi">Robi</option>
                                            <option value="teletalk">Teletalk</option>
                                            <option value="telenor">Telenor</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>MSISDN:</label>
                                        <input type="text" name="msisdn" class="form-control"
                                            placeholder="Enter MSISDN">
                                    </div>

                                    <div class="form-group" style="margin:0px;">
                                        <button class="btn btn-primary" type="submit"><i class="fe fe-search"></i>
                                            Go!</button>
                                    </div>
                                </form> --}}
                            </div>
                        </div>
                        <div class="table-responsive" style="overflow: hidden">
                            <table class="table card-table" id="userLogTableId">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Msisdn</th>
                                        <th>Email</th>
                                        <th>Joining Time</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(() => {
            url = '/admin/user/logs';
            table = $('#userLogTableId').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
                columns: [{
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.msisdn;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {

                            return row.email;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            console.log(row)

                            return row.last_login_time + ' ' + row.last_login_date;
                        },
                        targets: 0,
                    },

                ]
            });
        });
    </script>
@endpush
