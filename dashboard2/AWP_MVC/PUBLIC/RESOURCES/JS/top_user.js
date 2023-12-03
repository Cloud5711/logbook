function showGrades() {
    var categoryDropdown = document.getElementById("categoryDropdown");
    var selectedOption = categoryDropdown.options[categoryDropdown.selectedIndex].value;
    var gradesDropdown = document.getElementById("gradesDropdown");
    var programDropdownForCollege = document.getElementById("programForCollege");
    var gradeSelect = document.getElementById("grade");
    var departmentDropdownForCollege = document.getElementById("departmentDropdownForCollege");
    var gradeTable = document.getElementById("gradeTable");
    var resultTable = document.getElementById("resultTable");
    var top10Title = document.getElementById("top10Title");

    gradeSelect.innerHTML = '<option value="" readonly></option>';

    if (selectedOption !== "College") {
        programDropdownForCollege.innerHTML = '<option value="">Select Program</option>';
    }

    if (selectedOption === "Basic Education") {
        addGradeOption("Grade 1");
        addGradeOption("Grade 2");
        addGradeOption("Grade 3");
        addGradeOption("Grade 4");
        addGradeOption("Grade 5");
        addGradeOption("Grade 6");
        gradesDropdown.style.display = "block";
        departmentDropdownForCollege.style.display = "none";
        top10Title.style.display = "block";
    } else if (selectedOption === "Junior HS") {
        addGradeOption("Grade 7");
        addGradeOption("Grade 8");
        addGradeOption("Grade 9");
        addGradeOption("Grade 10");
        gradesDropdown.style.display = "block";
        departmentDropdownForCollege.style.display = "none";
        top10Title.style.display = "block";
    } else if (selectedOption === "Senior HS") {
        addGradeOption("Grade 11");
        addGradeOption("Grade 12");
        gradesDropdown.style.display = "block";
        departmentDropdownForCollege.style.display = "none";
        top10Title.style.display = "block";
    } else if (selectedOption === "College") {
        addDepartmentOption("CICS");
        addDepartmentOption("CCJE");
        addDepartmentOption("CBM");
        addDepartmentOption("CASTE");
        departmentDropdownForCollege.style.display = "block";
        programDropdownForCollege.style.display = "block";
        gradesDropdown.style.display = "none";
        top10Title.style.display = "block";
        gradeTable.style.display = "none";
        resultTable.style.display = "none";

        $("#gradeTable thead").hide();
    } else {
        gradesDropdown.style.display = "none";
        departmentDropdownForCollege.style.display = "none";
        gradeTable.style.display = "none";
        resultTable.style.display = "block";
        $("#gradeTable thead").hide();
        top10Title.style.display = "none";
        programDropdownForCollege.style.display = "block";
    }
}

function handleDepartmentSelection() {
    var selectedDepartment = document.getElementById("departmentDropdownForCollege").value; // Corrected ID
    var programDropdownForCollege = document.getElementById("programForCollege");
    var yearsDropdown = document.getElementById("year");

    // Clear previous options
    programDropdownForCollege.innerHTML = '<option value="">Select Program</option>';

    if (selectedDepartment === "CICS") {
        addProgramOption("BSIT");
        addProgramOption("BLISS");
        programDropdownForCollege.style.display = "block";
        yearsDropdown.style.display = "block";
    } else if (selectedDepartment === "CCJE") {
        addProgramOption("BSCRIM");
        programDropdownForCollege.style.display = "block";
        yearsDropdown.style.display = "block";
    } else if (selectedDepartment === "CBM") {
        addProgramOption("BSBA");
        addProgramOption("BSTM");
        programDropdownForCollege.style.display = "block";
        yearsDropdown.style.display = "block";
    } else if (selectedDepartment === "CASTE") {
        addProgramOption("BSED-ENG");
        addProgramOption("ABEC");
        addProgramOption("BEED");
        addProgramOption("BSED-MATH");
        addProgramOption("BSED-SCIE");
        addProgramOption("BS in Val. Ed.");
        addProgramOption("BSSW");
        programDropdownForCollege.style.display = "block";
        yearsDropdown.style.display = "block";
    } else {
        programDropdownForCollege.style.display = "none";
        yearsDropdown.style.display = "none";
    }
}

function addDepartmentOption(program) {
    var departmentDropdownForCollege = document.getElementById("departmentForCollege");
    var option = document.createElement("option");
    option.value = program;
    option.text = program;
    departmentDropdownForCollege.appendChild(option);
}


function addGradeOption(grade) {
    var gradeSelect = document.getElementById("grade");
    var option = document.createElement("option");
    option.value = grade;
    option.text = grade;
    gradeSelect.appendChild(option);
}

function handleGradeSelection() {
    var selectedGrade = document.getElementById("grade").value;
    if (selectedGrade !== "") {
        $.ajax({
            url: "fetch_topuser.php",
            type: "POST",
            data: 'grade=' + selectedGrade,
            success: function (data) {
                $("#gradeTable tbody").html(data);
                $("#gradeTable").show();
                $("#resultTable").hide();
                $("#gradeTable thead").show();
            }
        });
    }
}

function addYearOption(year) {
    var yearsDropdown = document.getElementById("year");
    var option = document.createElement("option");
    option.value = year;
    option.text = year;
    yearDropdown.appendChild(option);
}
