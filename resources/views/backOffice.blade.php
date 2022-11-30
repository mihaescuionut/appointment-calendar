<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment calendar</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ URL::asset('/libs/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datatable/datatables.min.css') }}">
    <script src="{{ URL::asset('libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('libs/flatpickr/flatpickr.min.js') }}"></script>
</head>

<body class="m-4">
    <div class="vh-50">
        <div class="d-flex flex-column justify-content-center align-items-center w-100" style="gap:1rem;">

            <div>
                <div class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Create a program</div>
            </div>

            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-m font-weight-bold text-primary text-uppercase mb-1"
                                style="text-align:center;font-size: 16px;font-weight: 500;color: #004b94;font-weight: 700;">
                                Program
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table dt-responsive" id="programTable" data-page-length='5'
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead style="background-color:#f3f5f7" class="text-center">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($programs as $program)
                                        <tr>
                                            <td class="align-middle text-center">
                                                {{ $program->date }}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ \Carbon\Carbon::parse($program->from)->format('H:i') . '-' . \Carbon\Carbon::parse($program->to)->format('H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">

                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-m font-weight-bold text-primary text-uppercase mb-1"
                                style="text-align:center;font-size: 16px;font-weight: 500;color: #004b94;font-weight: 700;">
                                appointments
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table dt-responsive" id="appointmentsTable" data-page-length='5'
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead style="background-color:#f3f5f7" class="text-center">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td class="align-middle text-center">
                                                {{ $appointment->date }}
                                            </td>
                                            <td class="align-middle text-center">
                                                {{ \Carbon\Carbon::parse($appointment->appointment_hour)->format('H:i') }}
                                            </td>
                                            <td class="align-middle text-center d-flex justify-content-center items-center"
                                                style="gap:0.5rem;">
                                                <div>
                                                    <a href="/delete/{{ $appointment->id }}"
                                                        class="btn btn-danger">Delete appointment
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create a program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="flatpickr">
                        <label for="date">Select date</label>
                        <input class="flatpickr form-control" id="date" name="date" required
                            style="border-radius:3px; height:36px ">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="create_btn">Create program</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


<script>
    $('#programTable').dataTable({
        ordering: false,
        language: {
            paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←'
            }
        },
        "pagingType": "simple_numbers",
    });

    $('#create_btn').on('click', function() {
        var date = $('#date').val();
        $.ajax({
            url: '/createProgram',
            type: 'POST',
            data: {
                date: date,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.status == 'success') {
                    console.log(success);
                }
            }
        });
    });

    flatpickr.localize(flatpickr.l10ns.ro);
    $("#date").flatpickr({
        enableTime: false,
        minDate: "today",
        monthSelectorType: "static",
        firstDayOfWeek: 1,
        mode: "range",
        disableMobile: true,
    });
</script>
