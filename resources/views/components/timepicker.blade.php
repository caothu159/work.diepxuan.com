<?php
$day = 0;
$week = 0;
?>
<form action="{{-- route('salary.thoigian', $time) --}}">
    @method('POST')
    @csrf
    <div class="form-group">
        <label for="exampleFormControlSelect1">Thời gian</label>
        <select class="form-control" id="exampleFormControlSelect1">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
</form>
