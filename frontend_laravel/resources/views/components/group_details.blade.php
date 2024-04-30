@php
        $id = $_GET['id'] ?? 'QR Code Detail';
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
    {{-- show Members Here  --}}
</div>