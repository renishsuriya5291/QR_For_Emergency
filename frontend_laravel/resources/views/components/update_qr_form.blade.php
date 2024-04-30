<!-- create_qr_form.blade.php -->

<div>
    <div class="form-group">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="unameInput" placeholder="Enter your name">
        <input type="hidden" id="uidInput" value="{{ $_GET['uid'] ?? '' }}">

    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="keyInput">Key</label>
            <input type="text" class="form-control" id="ukeyInput" placeholder="Enter key">
        </div>
        <div class="form-group col-md-5">
            <label for="valueInput">Value</label>
            <input type="text" class="form-control" id="uvalueInput" placeholder="Enter value">
        </div>
        <div class="form-group col-md-2 add_btn_div">
            <button type="button" class="btn btn-primary add_btn" id="ubtn" onclick="uaddKeyValue()">Add</button>
        </div>
    </div>
    <div class="fields mt-1" id="ufieldsDiv" style="display: none;">
        <!-- Field divs will be added dynamically here -->
    </div>
    <!-- Other fields -->
    <button type="submit" onclick="update_qr_submit()" class="btn btn-primary">Update QR</button>
</div>

