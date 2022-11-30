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
    <link rel="stylesheet" href="{{ asset('libs/sweetalert/sweetalert.min.css') }}">
    <script src="{{ URL::asset('libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('libs/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('libs/sweetalert/sweetalert2.all.min.js') }}"></script>
    </style>
</head>

<body>

    <section>

        <div class="card shadow-lg min-vh-100" style="padding-bottom:5rem;">

            <div class="row mx-auto" style="padding:5rem 0;">

                <div class="col-6 d-flex flex-column justify-content-start align-items-center px-4">

                    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
                        <h2 class="text-warning text-center" style="font-size:3.5rem;"> Time to make an</h2>
                        <h1 class="text-center" style="font-size:5rem;">Appointment</h1>

                        <div class="text-center w-75">
                            <span class="text-muted text-center">Lorem ipsum dolor sit amet consectetur adipisicing
                                elit.
                                Ratione laboriosam iusto vitae culpa aspernatur consequatur saepe placeat porro
                                fugiat qui?
                                Accusantium nesciunt et libero numquam sapiente, porro quasi iste magni! Lorem,
                                ipsum dolor
                                sit amet consectetur adipisicing elit. Voluptatem minima ea sit corrupti fuga autem
                                ipsam.
                                Amet quae minus debitis necessitatibus, temporibus nihil voluptatibus eveniet, non
                                eum quia
                                tempora soluta.</span>
                        </div>

                    </div>

                </div>


                <div class="col-6 d-flex flex-column justify-content-start align-items-center ">

                    <div class="border border-warning border-5 rounded p-4 w-75 m-4">

                        <h4 class="text-warning mb-4">Make the appointment</h4>

                        <form id="appointmentForm">
                            @csrf
                            <div class="w-100 d-flex flex-column justify-content-center align-items-center">
                                <div class="col-6">
                                    <div class="flatpickr">
                                        <label for="date">Select date</label>
                                        <input class="flatpickr form-control" id="date" name="date" required
                                            style="border-radius:3px; height:36px ">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="time" class="text-nowrap">Select time</label>
                                        <select id="time" class=" form-control w-100" data-input="" type="time"
                                            name="time" required onkeydown="return false">

                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-4 d-flex p-1">
                                    <button type="submit" class="btn btn-success waves-effect waves-light w-100">Make
                                        appointment!</button>
                                </div>
                            </div>

                        </form>
                    </div>


                </div>

            </div>
            <div class="col-6 mx-auto mb-4">
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
                                                <td class="align-middle text-center">
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

    </section>

</body>

</html>


<script>
    var appointments = '{!! $appointments !!}';
    appointments = JSON.parse(appointments);


    //initialize appointmentstable using datatable
    $('#appointmentsTable').dataTable({
        ordering: false,
        language: {
            paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←'
            }
        },
        "pagingType": "simple_numbers",
    });

    
    //initialize flatpickr
    $(document).ready(function() {
        $(function() {
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();
            var maxDate = year + '-' + month + '-' + day;

            flatpickr.localize(flatpickr.l10ns.ro);
            $("#date").flatpickr({
                enableTime: false,
                minDate: "today",
                monthSelectorType: "static",
                firstDayOfWeek: 1,
                disableMobile: true,
                "disable": [function(date) {
                    return (date.getDay() === 0 || date.getDay() === 6);
                }]
            });
        });
    })

    //get the available time slots for the appointments
    $('#date').on('change', function() {
        $('#time').empty();
        var date = $('#date').val();
        var time = $('#time').val();
        $.ajax({
            url: "{{ route('getHours') }}",
            method: "GET",
            data: {
                date: date,
                time: time,
            },
            success: function(data) {
                console.log(data);
                for (var i = 0; i < data.length; i++) {
                    $('#time').append('<option>' + data[i].substring(0, 5) + '</option>');
                }

            }
        });

    });

    //create the appointment
    $('#appointmentForm').on('submit', function(e) {
        e.preventDefault();
        var date = $('#date').val();
        var time = $('#time').val();
        $.ajax({
            url: "{{ route('makeAppointment') }}",
            method: "POST",
            data: {
                date: date,
                time: time,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your appointment has been saved!',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    setTimeout(function() {
                        location.reload();
                    }, 1600);
                }
            }
        });
    });
</script>
