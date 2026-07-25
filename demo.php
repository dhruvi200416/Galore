<html>

<head>
    <title>Registration Form</title>
</head>

<body> 
    <h2>Registration Form</h2>
    <form onsubmit="return validate()" method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br>
        <span id="error_field" style="color: red; font-size: 12px;"></span><br><br>
        <input type="submit" value="Register">
    </form>
</body>

</html>
<script>
    function validate() {
        var name = document.getElementById("name");
        var error_field = document.getElementById("error_field");
        var isValid = true;
        
        // Clear previous error
        error_field.innerHTML = "";
        name.style.borderColor = "";
        
        // Check if name is empty
        if (name.value.trim() == "") {
            error_field.innerHTML = "Name is required";
            error_field.style.color = "red";
            name.style.borderColor = "red";
            isValid = false;
        }
        // Check if name has at least 2 characters
        else if (name.value.trim().length < 2) {
            error_field.innerHTML = "Name must be at least 2 characters long";
            error_field.style.color = "red";
            name.style.borderColor = "red";
            isValid = false;
        }
        // Check if name contains only letters
        else {
            var name_regex = /^[a-zA-Z\s]+$/; // Added \s to allow spaces for full names
            if (!name_regex.test(name.value.trim())) {
                error_field.innerHTML = "Name must contain only letters and spaces";
                error_field.style.color = "red";
                name.style.borderColor = "red";
                isValid = false;
            }
            // If all validations pass
            else {
                error_field.innerHTML = "";
                name.style.borderColor = "green";
                return true; // Form will submit
            }
        }
        
        return isValid;
    }
</script>