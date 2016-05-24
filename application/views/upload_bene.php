
<html>
<head>
    <title>Upload Form</title>
</head>
<body>

<?php //echo $name;?>
<?php //echo $file_name->file_location; ?>
<?php echo form_open_multipart('cashforwork/do_upload/'.$cashforwork_brgy_id);?>

<input type="file" name="userfile" id = "userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>