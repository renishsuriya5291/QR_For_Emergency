<!-- create_qr_form.blade.php -->

<form>
    <div class="form-group">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="nameInput" placeholder="Enter your name">
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="keyInput">Key</label>
            <input type="text" class="form-control" id="keyInput" placeholder="Enter key">
        </div>
        <div class="form-group col-md-5">
            <label for="valueInput">Value</label>
            <input type="text" class="form-control" id="valueInput" placeholder="Enter value">
        </div>
        <div class="form-group col-md-2 add_btn_div">
            <button type="button" class="btn btn-primary add_btn"  onclick="addKeyValue()">Add</button>
        </div>
    </div>
    <div class="fields mt-1" id="fieldsDiv" style="display: none;">
        <!-- Field divs will be added dynamically here -->
    </div>
    <!-- Other fields -->
    <button type="submit" class="btn btn-primary">Create QR</button>
</form>

<script>
    
</script>
