<?php
include 'db_connection.php';
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Handle success and error messages
if (isset($_SESSION['success'])) {
    echo "<p style='color:green;'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
            background: #eef1f7;
        }
        #sidebar {
            background: #2c3e50;
            color: white;
            height: 100vh;
            width: 250px;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .main-content {
            flex-grow: 1;
            padding: 40px;
            margin-left: 250px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .toggle-btn {
            background: #ecf0f1;
            border-radius: 5px;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            display: none;
        }
        @media (max-width: 768px) {
            .toggle-btn {
                display: block;
            }
            .main-content {
                margin-left: 0;
            }
            #sidebar {
                margin-left: -250px;
            }
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link {
            border: none;
            border-radius: 0;
            color: #495057;
        }
        .nav-tabs .nav-link.active {
            background-color: #007bff;
            color: white;
        }
        .tab-content {
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .alert {
            border-radius: 8px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color:rgb(39, 41, 44);
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .circular-progress {
            position: absolute;
            top: 20px; /* Adjust as needed */
            right: 20px; /* Adjust as needed */
            width: 100px;
            height: 100px;
        }
        .circular-progress svg {
            transform: rotate(-90deg);
        }
        .circular-progress circle {
            fill: none;
            stroke-width: 10;
        }
        .circular-progress .progress-bg {
            stroke: #e6e6e6;
        }
        .circular-progress .progress {
            stroke: #007bff;
            transition: stroke-dashoffset 0.5s ease;
        }
        .completion-status {
            position: absolute;
            top: 35%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="wrapper">
    <div class="main-content">
        <button class="toggle-btn d-md-none" id="menuToggle" onclick="toggleSidebar()">
            <i class="bi bi-list"></i> Menu
        </button>
        <h2 class="text-center">Profile Page</h2>
  
        <ul class="nav nav-tabs" id="profileTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#personalInfo">Personal Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#academicInfo">Academic Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#accommodationPreferences">Accommodation Preferences</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#emergencyContact">Emergency Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#guarantorDetails">Guarantor Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#documentsUpload">Documents Upload</a>
            </li>
        </ul>
        
      

    <div class="tab-content mt-3 p-4 border rounded shadow-sm bg-white">
    <div class="tab-pane fade show active" id="personalInfo">
    <form id="personalInfoForm" method="POST" action="save_personal_info.php">
        <h4>Personal Information</h4>
        
        <div class="form-group">
            <label for="identityNo">Identity Number / Passport Number</label>
            <input type="text" class="form-control" id="identity_no" name="identity_no" placeholder="Enter your identity number" required>
        </div>
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
        </div>
        <div class="form-group">
            <label for="dateOfBirth">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
        </div>
        <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state" required>
        </div>
        <div class="form-group">
            <label for="zipCode">Zip Code</label>
            <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Enter your zip code" required>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="Enter your country" required>
        </div>

        <!-- Save Button -->
        <button type="submit" class="btn btn-primary">Save Personal Info</button>

        <!-- Edit Button -->
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editModal">Edit</button>
    </form>
</div>

<!-- Modal for Editing Personal Information -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Personal Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPersonalInfoForm" method="POST" action="save_personal_info.php">
                    <div class="form-group">
                        <label for="editIdentityNo">Identity Number / Passport Number</label>
                        <input type="text" class="form-control" id="edit_identity_no" name="identity_no" required>
                    </div>
                    <div class="form-group">
                        <label for="editFirstName">First Name</label>
                        <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editLastName">Last Name</label>
                        <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editDateOfBirth">Date of Birth</label>
                        <input type="date" class="form-control" id="edit_date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhoneNumber">Phone Number</label>
                        <input type="text" class="form-control" id="edit_phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="editCity">City</label>
                        <input type="text" class="form-control" id="edit_city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="editState">State</label>
                        <input type="text" class="form-control" id="edit_state" name="state" required>
                    </div>
                    <div class="form-group">
                        <label for="editZipCode">Zip Code</label>
                        <input type="text" class="form-control" id="edit_zip_code" name="zip_code" required>
                    </div>
                    <div class="form-group">
                        <label for="editCountry">Country</label>
                        <input type="text" class="form-control" id="edit_country" name="country" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="tab-pane fade" id="academicInfo">
    <form id="academicInfoForm" action="save_academic_info.php" method="POST">
        <h4>Academic Information</h4>
        <div class="form-group">
            <label for="studentNo">Student Number</label>
            <input type="text" class="form-control" name="student_no" id="studentNo" placeholder="Enter your student number" required>
        </div>
        <div class="form-group">
            <label for="institutionName">Institution Name</label>
            <input type="text" class="form-control" name="institution_name" id="institutionName" placeholder="Enter your institution name" required>
        </div>
        <div class="form-group">
            <label for="studyProgramme">Study Programme</label>
            <input type="text" class="form-control" name="study_programme" id="studyProgramme" placeholder="Enter your study programme" required>
        </div>
        <div class="form-group">
            <label for="startDate">Start Date</label>
            <input type="date" class="form-control" name="start_date" id="startDate" required>
        </div>
        <div class="form-group">
            <label for="endDate">End Date</label>
            <input type="date" class="form-control" name="end_date" id="endDate" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Academic Info</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editAcademicModal">Edit</button>
    </form>
</div>

<!-- Modal for Editing Academic Information -->
<div class="modal fade" id="editAcademicModal" tabindex="-1" role="dialog" aria-labelledby="editAcademicModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAcademicModalLabel">Edit Academic Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAcademicInfoForm" method="POST" action="save_academic_info.php">
                    <input type="hidden" id="academic_record_id" name="academic_record_id">
                    <div class="form-group">
                        <label for="editStudentNo">Student Number</label>
                        <input type="text" class="form-control" id="edit_student_no" name="student_no" required>
                    </div>
                    <div class="form-group">
                        <label for="editInstitutionName">Institution Name</label>
                        <input type="text" class="form-control" id="edit_institution_name" name="institution_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editStudyProgramme">Study Programme</label>
                        <input type="text" class="form-control" id="edit_study_programme" name="study_programme" required>
                    </div>
                    <div class="form-group">
                        <label for="editStartDate">Start Date</label>
                        <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label for="editEndDate">End Date</label>
                        <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal with existing data when the edit button is clicked
    $('#editAcademicModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var studentNo = button.closest('.record').find('.student_no').text(); // Assuming you have a way to get the student number
        var institutionName = button.closest('.record').find('.institution_name').text(); // Assuming you have a way to get the institution name
        var studyProgramme = button.closest('.record').find('.study_programme').text(); // Assuming you have a way to get the study programme
        var startDate = button.closest('.record').find('.start_date').text(); // Assuming you have a way to get the start date
        var endDate = button.closest('.record').find('.end_date').text(); // Assuming you have a way to get the end date
        var recordId = button.data('id'); // Assuming you have a data-id attribute for the record ID

        // Update the modal's content
        var modal = $(this);
        modal.find('#edit_student_no').val(studentNo);
        modal.find('#edit_institution_name').val(institutionName);
        modal.find('#edit_study_programme').val(studyProgramme);
        modal.find('#edit_start_date').val(startDate);
        modal.find('#edit_end_date').val(endDate);
        modal.find('#academic_record_id').val(recordId);
    });
</script>

<div class="tab-pane fade" id="accommodationPreferences">
    <form id="accommodationPreferencesForm" action="save_accommodation_preferences.php" method="POST">
        <h4>Accommodation Preferences</h4>
        <div class="form-group">
            <label for="propertyType">Property Type</label>
            <select class="form-control" name="property_type" id="propertyType" required>
                <option value="">Select property type</option>
                <option value="shared">Shared Room</option>
                <option value="single">Single Room</option>
                <option value="ensuite">Ensuite</option>
            </select>
        </div>
        <div class="form-group">
            <label for="checkInDate">Check-in Date</label>
            <input type="date" class="form-control" name="check_in_date" id="checkInDate" required>
        </div>
        <div class="form-group">
            <label for="checkOutDate">Check-out Date</label>
            <input type="date" class="form-control" name="check_out_date" id="checkOutDate" required>
        </div>
        <div class="form-group">
            <label for="specialRequirements">Special Requirements</label>
            <textarea class="form-control" name="special_requirements" id="specialRequirements" rows="2" placeholder="Any special requests?"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Accommodation Preferences</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editAccommodationModal">Edit</button>
    </form>
</div>

<!-- Modal for Editing Accommodation Preferences -->
<div class="modal fade" id="editAccommodationModal" tabindex="-1" role="dialog" aria-labelledby="editAccommodationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAccommodationModalLabel">Edit Accommodation Preferences</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAccommodationInfoForm" method="POST" action="save_accommodation_preferences.php">
                    <input type="hidden" id="accommodation_record_id" name="accommodation_record_id">
                    <div class="form-group">
                        <label for="editPropertyType">Property Type</label>
                        <select class="form-control" name="property_type" id="editPropertyType" required>
                            <option value="">Select property type</option>
                            <option value="shared">Shared Room</option>
                            <option value="single">Single Room</option>
                            <option value="ensuite">Ensuite</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editCheckInDate">Check-in Date</label>
                        <input type="date" class="form-control" name="check_in_date" id="editCheckInDate" required>
                    </div>
                    <div class="form-group">
                        <label for="editCheckOutDate">Check-out Date</label>
                        <input type="date" class="form-control" name="check_out_date" id="editCheckOutDate" required>
                    </div>
                    <div class="form-group">
                        <label for="editSpecialRequirements">Special Requirements</label>
                        <textarea class="form-control" name="special_requirements" id="editSpecialRequirements" rows="2" placeholder="Any special requests?"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal with existing data when the edit button is clicked
    $('#editAccommodationModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var propertyType = button.closest('.record').find('.property_type').text(); // Assuming you have a way to get the property type
        var checkInDate = button.closest('.record').find('.check_in_date').text(); // Assuming you have a way to get the check-in date
        var checkOutDate = button.closest('.record').find('.check_out_date').text(); // Assuming you have a way to get the check-out date
        var specialRequirements = button.closest('.record').find('.special_requirements').text(); // Assuming you have a way to get the special requirements
        var recordId = button.data('id'); // Assuming you have a data-id attribute for the record ID

        // Update the modal's content
        var modal = $(this);
        modal.find('#editPropertyType').val(propertyType);
        modal.find('#editCheckInDate').val(checkInDate);
        modal.find('#editCheckOutDate').val(checkOutDate);
        modal.find('#editSpecialRequirements').val(specialRequirements);
        modal.find('#accommodation_record_id').val(recordId);
    });
</script>

<div class="tab-pane fade" id="emergencyContact">
    <form id="emergencyContactForm" action="save_emergency_contact.php" method="POST">
        <h4>Emergency Contact</h4>
        <div class="form-group">
            <label for="emergencyName">Emergency Contact Name</label>
            <input type="text" class="form-control" name="contact_name" id="emergencyName" placeholder="Enter emergency contact name" required>
        </div>
        <div class="form-group">
            <label for="emergencyPhone">Emergency Contact Phone</label>
            <input type="text" class="form-control" name="contact_phone" id="emergencyPhone" placeholder="Enter emergency contact phone" required>
        </div>
        <div class="form-group">
            <label for="emergencyRelationship">Relationship to Emergency Contact</label>
            <input type="text" class="form-control" name="relationship" id="emergencyRelationship" placeholder="Enter relationship (e.g., parent, friend)" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Emergency Contact</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editEmergencyModal">Edit</button>
    </form>
</div>

<!-- Modal for Editing Emergency Contact -->
<div class="modal fade" id="editEmergencyModal" tabindex="-1" role="dialog" aria-labelledby="editEmergencyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmergencyModalLabel">Edit Emergency Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEmergencyContactForm" method="POST" action="save_emergency_contact.php">
                    <input type="hidden" id="emergency_record_id" name="emergency_record_id">
                    <div class="form-group">
                        <label for="editEmergencyName">Emergency Contact Name</label>
                        <input type="text" class="form-control" id="editEmergencyName" name="contact_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmergencyPhone">Emergency Contact Phone</label>
                        <input type="text" class="form-control" id="editEmergencyPhone" name="contact_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmergencyRelationship">Relationship to Emergency Contact</label>
                        <input type="text" class="form-control" id="editEmergencyRelationship" name="relationship" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal with existing data when the edit button is clicked
    $('#editEmergencyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var contactName = button.closest('.record').find('.contact_name').text(); // Assuming you have a way to get the contact name
        var contactPhone = button.closest('.record').find('.contact_phone').text(); // Assuming you have a way to get the contact phone
        var relationship = button.closest('.record').find('.relationship').text(); // Assuming you have a way to get the relationship
        var recordId = button.data('id'); // Assuming you have a data-id attribute for the record ID

        // Update the modal's content
        var modal = $(this);
        modal.find('#editEmergencyName').val(contactName);
        modal.find('#editEmergencyPhone').val(contactPhone);
        modal.find('#editEmergencyRelationship').val(relationship);
        modal.find('#emergency_record_id').val(recordId);
    });
</script>

<div class="tab-pane fade" id="guarantorDetails">
    <form id="guarantorDetailsForm" action="save_guarantor_details.php" method="POST" enctype="multipart/form-data">
        <h4>Guarantor Details</h4>
        <div class="form-group">
            <label for="guarantorName">Guarantor Name</label>
            <input type="text" class="form-control" name="guarantor_name" id="guarantorName" placeholder="Enter guarantor name" required>
        </div>
        <div class="form-group">
            <label for="guarantorPhone">Guarantor Phone</label>
            <input type="text" class="form-control" name="guarantor_phone" id="guarantorPhone" placeholder="Enter guarantor phone" required>
        </div>
        <div class="form-group">
            <label for="guarantorEmail">Guarantor Email</label>
            <input type="email" class="form-control" name="guarantor_email" id="guarantorEmail" placeholder="Enter guarantor email" required>
        </div>
        <div class="form-group">
            <label for="guarantorEmploymentStatus">Employment Status</label>
            <select class="form-control" name="employment_status" id="guarantorEmploymentStatus" required>
                <option value="">Select employment status</option>
                <option value="employed">Employed</option>
                <option value="unemployed">Unemployed</option>
                <option value="self-employed">Self-Employed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="guarantorSalaryRange">Salary Range</label>
            <input type="text" class="form-control" name="salary_range" id="guarantorSalaryRange" placeholder="Enter salary range (e.g., R10,000 - R15,000)" required>
        </div>
        <div class="form-group">
            <label for="proofOfIncome">Upload Proof of Income</label>
            <input type="file" class="form-control-file" name="proof_of_income" id="proofOfIncome" required>
            <small class="form-text text-muted">Please upload a recent payslip or proof of income.</small>
        </div>
        <button type="submit" class="btn btn-primary">Save Guarantor Details</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editGuarantorModal">Edit</button>
    </form>
</div>

<!-- Modal for Editing Guarantor Details -->
<div class="modal fade" id="editGuarantorModal" tabindex="-1" role="dialog" aria-labelledby="editGuarantorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuarantorModalLabel">Edit Guarantor Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editGuarantorForm" method="POST" action="save_guarantor_details.php" enctype="multipart/form-data">
                    <input type="hidden" id="guarantor_record_id" name="guarantor_record_id">
                    <div class="form-group">
                        <label for="editGuarantorName">Guarantor Name</label>
                        <input type="text" class="form-control" id="editGuarantorName" name="guarantor_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editGuarantorPhone">Guarantor Phone</label>
                        <input type="text" class="form-control" id="editGuarantorPhone" name="guarantor_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="editGuarantorEmail">Guarantor Email</label>
                        <input type="email" class="form-control" id="editGuarantorEmail" name="guarantor_email" required>
                    </div>
                    <div class="form-group">
                        <label for="editGuarantorEmploymentStatus">Employment Status</label>
                        <select class="form-control" name="employment_status" id="editGuarantorEmploymentStatus" required>
                            <option value="">Select employment status</option>
                            <option value="employed">Employed</option>
                            <option value="unemployed">Unemployed</option>
                            <option value="self-employed">Self-Employed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editGuarantorSalaryRange">Salary Range</label>
                        <input type="text" class="form-control" id="editGuarantorSalaryRange" name="salary_range" required>
                    </div>
                    <div class="form-group">
                        <label for="editProofOfIncome">Upload Proof of Income</label>
                        <input type="file" class="form-control-file" name="proof_of_income" id="editProofOfIncome">
                        <small class="form-text text-muted">Please upload a recent payslip or proof of income.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal with existing data when the edit button is clicked
    $('#editGuarantorModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var guarantorName = button.closest('.record').find('.guarantor_name').text(); // Assuming you have a way to get the guarantor name
        var guarantorPhone = button.closest('.record').find('.guarantor_phone').text(); // Assuming you have a way to get the guarantor phone
        var guarantorEmail = button.closest('.record').find('.guarantor_email').text(); // Assuming you have a way to get the guarantor email
        var employmentStatus = button.closest('.record').find('.employment_status').text(); // Assuming you have a way to get the employment status
        var salaryRange = button.closest('.record').find('.salary_range').text(); // Assuming you have a way to get the salary range
        var recordId = button.data('id'); // Assuming you have a data-id attribute for the record ID

        // Update the modal's content
        var modal = $(this);
        modal.find('#editGuarantorName').val(guarantorName);
        modal.find('#editGuarantorPhone').val(guarantorPhone);
        modal.find('#editGuarantorEmail').val(guarantorEmail);
        modal.find('#editGuarantorEmploymentStatus').val(employmentStatus);
        modal.find('#editGuarantorSalaryRange').val(salaryRange);
        modal.find('#guarantor_record_id').val(recordId);
    });
</script>

<div class="tab-pane fade" id="documentsUpload">
    <form id="documentsUploadForm" action="upload_documents.php" method="POST" enctype="multipart/form-data">
        <h4>Upload Required Documents</h4>
        <div class="form-group">
            <label for="proofOfFunding">Proof of Funding</label>
            <input type="file" class="form-control-file" name="proof_of_funding" id="proofOfFunding" required>
        </div>
        <div class="form-group">
            <label for="idOrPassport">ID/Passport</label>
            <input type="file" class="form-control-file" name="id_or_passport" id="idOrPassport" required>
        </div>
        <div class="form-group">
            <label for="proofOfRegistration">Proof of Registration</label>
            <input type="file" class="form-control-file" name="proof_of_registration" id="proofOfRegistration" required>
        </div>
        <div class="form-group">
            <label for="proofOfAddress">Proof of Address</label>
            <input type="file" class="form-control-file" name="proof_of_address" id="proofOfAddress" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload Documents</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#editDocumentsModal">Edit</button>
    </form>
</div>

<!-- Modal for Editing Document Uploads -->
<div class="modal fade" id="editDocumentsModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDocumentsModalLabel">Edit Document Uploads</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDocumentsForm" method="POST" action="upload_documents.php" enctype="multipart/form-data">
                    <input type="hidden" id="documents_record_id" name="documents_record_id">
                    <div class="form-group">
                        <label for="editProofOfFunding">Proof of Funding</label>
                        <input type="file" class="form-control-file" name="proof_of_funding" id="editProofOfFunding">
                        <small class="form-text text-muted">Leave blank if not changing.</small>
                    </div>
                    <div class="form-group">
                        <label for="editIdOrPassport">ID/Passport</label>
                        <input type="file" class="form-control-file" name="id_or_passport" id="editIdOrPassport">
                        <small class="form-text text-muted">Leave blank if not changing.</small>
                    </div>
                    <div class="form-group">
                        <label for="editProofOfRegistration">Proof of Registration</label>
                        <input type="file" class="form-control-file" name="proof_of_registration" id="editProofOfRegistration">
                        <small class="form-text text-muted">Leave blank if not changing.</small>
                    </div>
                    <div class="form-group">
                        <label for="editProofOfAddress">Proof of Address</label>
                        <input type="file" class="form-control-file" name="proof_of_address" id="editProofOfAddress">
                        <small class="form-text text-muted">Leave blank if not changing.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Populate the modal with existing data when the edit button is clicked
    $('#editDocumentsModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recordId = button.data('id'); // Assuming you have a data-id attribute for the record ID

        // Update the modal's content
        var modal = $(this);
        modal.find('#documents_record_id').val(recordId);
        // You can also populate existing file names or other data if needed
    });
</script>


    </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Sidebar Toggle Function
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        var mainContent = document.querySelector(".main-content");
        var toggleBtn = document.getElementById("menuToggle");
        
        if (sidebar.style.marginLeft === "0px" || sidebar.style.marginLeft === "") {
            sidebar.style.marginLeft = "-250px";
            mainContent.style.marginLeft = "0px";
            toggleBtn.style.display = "block";
        } else {
            sidebar.style.marginLeft = "0px";
            mainContent.style.marginLeft = "250px";
            toggleBtn.style.display = "none";
        }
    }
//////////////////////////


</script>
</body>
</html>