@php
        $groupName = $_GET['groupName'] ?? 'QR Code Detail';
@endphp

<div class="container d-flex justify-content-between">
    <div class="head_text">
        <h5 id="rightHeading">{{$groupName}}</h5>
    </div>
    <div class="btns" id="exportBtnContainer">
        <button class="btn btn-primary font-semibold" onclick="add_member_form()">Add Member</button>
    </div>
</div>

<div class="container mt-5" id="qrDetails">
    <div class="container qr_field_detail my-3">
        <div class="text-container">
            <span class="text">Emergency Number : </span>
            <span class="text">+91 12365 09876</span>
        </div>
        <div class="bin-container">
            <i class="fas fa-trash-alt bin-icon"></i>
        </div>
    </div>
    <div class="container qr_field_detail my-3">
        <div class="text-container">
            <span class="text">Emergency Number : </span>
            <span class="text">+91 12365 09876</span>
        </div>
        <div class="bin-container">
            <i class="fas fa-trash-alt bin-icon"></i>
        </div>
    </div>
    <div class="container qr_field_detail my-3">
        <div class="text-container">
            <span class="text">Emergency Number : </span>
            <span class="text">+91 12365 09876</span>
        </div>
        <div class="bin-container">
            <i class="fas fa-trash-alt bin-icon"></i>
        </div>
    </div>
</div>