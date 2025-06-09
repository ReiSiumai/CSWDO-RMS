@extends('layouts.app')
@section('title', 'Applicant Status')
@section('content')
@foreach ($clients as $client)
<div class="modal fade" id="viewClientModal{{ $client->id }}" tabindex="-1" aria-labelledby="viewClientLabel{{ $client->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewClientLabel{{ $client->id }}">Applicant Details</h5>
                <button type="button" onclick="closeModal({{$client->id}})" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="client-info">
                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Control No:</strong> {{ $client->control_number }}</div>
                        <div class="col-md-6"><strong>First Name:</strong> {{ $client->first_name }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Last Name:</strong> {{ $client->last_name }}</div>
                        <div class="col-md-6"><strong>Middle Name:</strong> {{ $client->middle }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Suffix:</strong> {{ $client->suffix }}</div>
                        <div class="col-md-6"><strong>Age:</strong> {{ $client->age }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Sex:</strong> {{ $client->sex }}</div>
                        <div class="col-md-6"><strong>Date of Birth:</strong> {{ $client->date_of_birth }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Place of Birth:</strong> {{ $client->pob }}</div>
                        <div class="col-md-6"><strong>Educational Attainment:</strong> {{ $client->educational_attainment }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Civil Status:</strong> {{ $client->civil_status }}</div>
                        <div class="col-md-6"><strong>Religion:</strong> {{ $client->religion }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Nationality:</strong> {{ $client->nationality }}</div>
                        <div class="col-md-6"><strong>Occupation:</strong> {{ $client->occupation }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Monthly Income:</strong> {{ $client->monthly_income }}</div>
                        <div class="col-md-6"><strong>Contact Number:</strong> {{ $client->contact_number }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Building Number:</strong> {{ $client->building_number ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Street Name:</strong> {{ $client->street_name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Barangay:</strong> {{ $client->barangay ?? 'N/A' }}
                        </div>
                    </div>
                    <hr>
                    <h6 class="text-muted mb-3">Household Information</h6>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>House Structure:</strong> {{ $client->house_structure }}</div>
                        <div class="col-md-6"><strong>Number of Rooms:</strong> {{ $client->number_of_rooms }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6"><strong>Appliances:</strong> {{ $client->appliances }}</div>
                        <div class="col-md-6">
                            <strong>Monthly Expenses:</strong>
                            @php
                                $expenses = json_decode($client->monthly_expenses, true); // Decode JSON data into an associative array
                            @endphp

                            @if (is_array($expenses) && count($expenses) > 0)
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>Expense Type</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expenses as $key => $value)
                                            @if (!empty($value)) <!-- Check if value is not empty -->
                                                <tr>
                                                    <td>{{ ucfirst($key) }}</td>
                                                    <td>₱{{ number_format((float)$value, 2) }}</td> <!-- Cast to float -->
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="text-muted mt-2">No expenses data available.</div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="generatePdf({{ $client->id }})">
                    <i class="fas fa-file-pdf"></i> Generate PDF
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeModal({{$client->id}})" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    function generatePdf(clientId) {
		window.location.href = '/generate-pdf/' + clientId;
	}
    function closeModal(clientId) {
			const modalId = `viewClientModal${clientId}`;
			const modal = document.getElementById(modalId);
			const backdrop = document.querySelector('.modal-backdrop');

			if (modal) {
				modal.classList.remove('show');
				modal.style.display = 'none';
				document.body.classList.remove('modal-open');
				document.body.style = '';
			}

			if (backdrop) {
				backdrop.remove();
			}
		}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="main-content mx-auto">
    <section class="section">
        <div class="section-header">
            <h1>Applicant Status</h1>
        </div>

        <div class="section-body">
            <div class="input-group" style="max-width: 500px; margin-bottom: 20px;">
                <input type="text" id="searchInput" class="form-control" placeholder="Search Client">
                <button class="btn btn-primary" style="margin-left:5px;" type="submit">Search</button>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Applicants with Closed Tracking</h4>
                </div>
                <div class="card-body">
                    <!-- Wrap table inside a responsive container -->
                    <div class="table-responsive">
                        <table class="table table-striped" id="clientTable">
                            <thead>
                                <tr>
                                    <th>Control No.</th>
                                    <th>Name</th>
                                    <th>Suffix</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Date of Birth</th>
                                    <th>Nationality</th>
                                    <th>Contact Number</th>
                                    <th>Case Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="searchResults">
                                @foreach ($clients as $client)
                                <tr>
                                    <td class="controlnumber">{{ $client->control_number }}</td>
                                    <td class="fullname">{{ $client->first_name }} {{ $client->last_name }}</td>
                                    <td class="suffix">{{ $client->suffix }}</td>
                                    <td class="age">{{ $client->age }}</td>
                                    <td class="sex">{{ $client->sex }}</td>
                                    <td class="birthday">{{ $client->date_of_birth }}</td>
                                    <td class="nationality">{{ $client->nationality }}</td>
                                    <td class="contactnumber">{{ $client->contact_number }}</td>
                                    <td class="case-status" style="padding: 5px; text-align: center;">
                                        <span style="
                                            background-color: {{ $client->tracking == 'Approve' ? 'green' : 'transparent' }};
                                            color: white;
                                            padding: 2px 4px;
                                            border-radius: 4px;">
                                            {{ $client->tracking == 'Approve' ? 'Closed' : 'Not Tracking' }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <!-- View Button -->
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewClientModal{{ $client->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <!-- Duplicate Record Button -->
                                        <button type="button" class="btn btn-primary text-xs duplicate-btn" onclick="duplicateRecord({{ $client->id }})">
                                            <i class="fas fa-copy"></i> <span class="d-none d-sm-inline"><small>Duplicate Record</small></span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- End table-responsive -->
                </div>
            </div>
        </div>
    </section>
    {{-- @include('layouts.social-worker.view-modal', ['client' => $client]) <!-- Pass the client variable --> --}}

    <!-- Success Message -->
    <div id="successMessage" class="alert alert-success" style="display: none;">
        Record successfully duplicated!
    </div>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    @section('scripts')
	<script>
		// use data table for table id clientTable
		$(document).ready(function() {
			$('#clientTable').DataTable({
				"paging": true,
				"info": false,
				"searching": true,
                "order": [] // Disable auto ordering
			});
		});
	</script>
    @endsection

    <script>
        // Function to handle record duplication
        function duplicateRecord(clientId) {
            if (confirm("Are you sure you want to duplicate this record?")) {
                fetch(`/duplicate-client/${clientId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('successMessage').style.display = 'block';
                        setTimeout(() => {
                            document.getElementById('successMessage').style.display = 'none';
                        }, 3000);
                    } else {
                        alert("An error occurred while duplicating the record.");
                    }
                })
                .catch(error => {
                    console.error("Error duplicating record:", error);
                    alert("An error occurred while duplicating the record.");
                });
            }
        }

        // Search Functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#searchResults tr');

            tableRows.forEach(row => {
                const controlNum = row.querySelector('.controlnumber').textContent.toLowerCase();
                const fullname = row.querySelector('.fullname').textContent.toLowerCase();
                const suffix = row.querySelector('.suffix').textContent.toLowerCase();
                const age = row.querySelector('.age').textContent.toLowerCase();
                const sex = row.querySelector('.sex').textContent.toLowerCase();
                const birthday = row.querySelector('.birthday').textContent.toLowerCase();
                const nationality = row.querySelector('.nationality').textContent.toLowerCase();
                const contactnumber = row.querySelector('.contactnumber').textContent.toLowerCase();
                const casestatus = row.querySelector('.case-status').textContent.toLowerCase();

                if (controlNum.includes(searchTerm) || fullname.includes(searchTerm) || suffix.includes(searchTerm) || age.includes(searchTerm) ||
                    sex.includes(searchTerm) || birthday.includes(searchTerm) || nationality.includes(searchTerm) || contactnumber.includes(searchTerm) ||
                    casestatus.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</div>
@endsection
