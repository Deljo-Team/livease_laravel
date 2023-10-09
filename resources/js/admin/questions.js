import axios from "axios";

//load the functions after the page is loaded without jquery
window.addEventListener("load", function () {
    var token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    let category = document.getElementById("category");
    let subcategoryElement = document.getElementById("sub_category");
    if (category.value != "" && subcategoryElement.value != "") {
        let questionsData = getQuestions(subcategoryElement.value);
    }
    category.addEventListener("change", function () {
        let category_id = this.value;
        if (category_id == "") {
            return;
        }
        let question_section = document.getElementById("question-section");
        question_section.innerHTML = "";
        let url = sub_category_url;
        let data = {
            categories: [category_id],
            _token: token,
        };
        axios
            .post(url, data)
            .then(function (response) {
                let categories = response.data.Data.categories || [];
                let subcategories = categories[0].sub_categories || [];

                subcategoryElement.innerHTML = "";
                let option = createOption("", "Select Subcategory");
                subcategoryElement.appendChild(option);
                subcategories.forEach(function (subcategory) {
                    let option = createOption(subcategory.id, subcategory.name);
                    subcategoryElement.appendChild(option);
                });
            })
            .catch(function (error) {
                console.log(error);
            });
    });

    subcategoryElement.addEventListener("change", function () {
        let subcategory_id = this.value;
        if (subcategory_id == "") {
            return;
        }
        let questionsData = getQuestions(subcategoryElement.value);
    });
    function getQuestions(subcategory_id) {
        let url = `${question_url}/show`;
        return axios
            .post(url, {
                subcategory_id: subcategory_id,
                _token: token,
            })
            .then(function (response) {
                let question_section =
                    document.getElementById("question-section");
                question_section.innerHTML = response.data.html;
                loadScripts();
            });
    }

    function createOption(value, text) {
        let option = document.createElement("option");
        option.value = value;
        option.innerText = text;
        return option;
    }
});

// Path: resources/js/admin/questions.js
function loadScripts() {
    let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
    let priorities = document.querySelectorAll(".priority");
    priorities.forEach(function (priority) {
        priority.addEventListener("click", function () {
            let question_id = this.closest(".accordion-header").dataset.id;
            let priority = this.dataset.move;
            let url = `${question_url}/priority`;
            let data = {
                priority: priority,
                id: question_id,
                _token: token,
            };
            axios
                .post(url, data)
                .then(function (response) {
                    let subcategoryElement = document.getElementById('sub_category');
                    getQuestions(subcategoryElement.value);
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    });

    //status
    let statusButtons = document.querySelectorAll(".status");
    statusButtons.forEach(function (status) {
        status.addEventListener("click", function () {
            let question_id = this.closest(".accordion-header").dataset.id;
            let status = this.dataset.status;
            let url = `${question_url}/status`;
            
            let data = {
                status: status,
                id: question_id,
                _token: token,
            };
            axios
                .post(url, data)
                .then(function (response) {
                    let subcategoryElement = document.getElementById('sub_category');
                    getQuestions(subcategoryElement.value);
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    });

    let addQuestionButton = document.getElementById("add-question");
    var myModal = new bootstrap.Modal(document.getElementById("myModal"));
    addQuestionButton.addEventListener("click", function () {
        let url = `${question_url}/create`;

        let data = {};
        axios
            .post(url, data)
            .then(function (response) {
                let modal_content = document.getElementById("modal-content");
                modal_content.innerHTML = response.data.html;
                myModal.show();
                loadCreateScripts();
            })
            .catch(function (error) {
                myModal.hide();
                let modal_content = document.getElementById("modal-content");

                modal_content.innerHTML = "";
                console.log(error);
            });
    });
    //Edit
    let editButtons = document.querySelectorAll(".edit");
    editButtons.forEach(function (editButton) {
        editButton.addEventListener("click", function () {
            let token = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content");
            let question_id = this.closest(".accordion-header").dataset.id;
            let url = `${question_url}/edit`;
            let data = {
                id: question_id,
                _token: token,
            };
            axios
                .post(url, data)
                .then(function (response) {
                    let modal_content =
                        document.getElementById("modal-content");
                    modal_content.innerHTML = response.data.html;
                    myModal.show();
                    loadCreateScripts();
                })
                .catch(function (error) {
                    myModal.hide();
                    let modal_content =
                        document.getElementById("modal-content");

                    modal_content.innerHTML = "";
                    console.log(error);
                });
        });
    });

    //Delete
    let deleteButtons = document.querySelectorAll(".delete");
    deleteButtons.forEach(function (deleteButton) {
        deleteButton.addEventListener("click", function () {
            let question_id = this.closest(".accordion-header").dataset.id;
            let url = `${question_url}/destroy`;
            let data = {
                id: question_id,
            };
            swal.fire({
                title: "Are you sure?",
                text: "This will delete the item permanently.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.value) {
                    // Delete the item
                    axios
                        .post(url, data)
                        .then(function (response) {
                            if (response.data.success) {
                                swal.fire(
                                    "Success",
                                    "Question deleted successfully",
                                    "success"
                                ).then(function () {
                                    let subcategoryElement =
                                        document.getElementById("sub_category");
                                    getQuestions(subcategoryElement.value);
                                });
                            } else {
                                swal.fire(
                                    "Error",
                                    response.data.message,
                                    "error"
                                );
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        });
    });
    function getQuestions(subcategory_id) {
        let token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        let url = `${question_url}/show`;
        return axios
            .post(url, {
                subcategory_id: subcategory_id,
                _token: token,
            })
            .then(function (response) {
                let question_section =
                    document.getElementById("question-section");
                question_section.innerHTML = response.data.html;
                loadScripts();
            });
    }
}

function loadCreateScripts() {
    let questionTypeSelect = document.getElementById("question-type");
    if (questionTypeSelect != null) {
        questionTypeSelect.addEventListener("change", function () {
            let option_section = document.getElementById("option-create");
            let question_type = this.value;
            if (question_type == "select") {
                var optionCount = 1;
                option_section.classList.remove("d-none");
                showHideOptionRemoveButtons();
            } else {
                var optionCount = 0;
                option_section.classList.add("d-none");
            }
        });
    }
    let optionRemoveButtons = document.querySelectorAll(".remove-option");
    optionRemoveButtons.forEach(function (optionRemoveButton) {
        optionRemoveButton.addEventListener("click", deleteOptionRow);
    });
    let optionAddButton = document.getElementById("add-option");
    optionAddButton.addEventListener("click", optionAddButtonClicked);

    function optionAddButtonClicked() {
        let option = document.querySelector(".option-row");
        let optionClone = option.cloneNode(true);
        let options = document.getElementById("option-list");
        let newOption = options.appendChild(optionClone);
        newOption.querySelector(".option").value = "";
        newOption
            .querySelector(".remove-option")
            .addEventListener("click", deleteOptionRow);
        showHideOptionRemoveButtons();
    }
    function showHideOptionRemoveButtons() {
        let optionRows = document.querySelectorAll(".option-row");
        let optionRemoveButtons = document.querySelectorAll(".remove-option");
        optionRemoveButtons.forEach(function (optionRemoveButton) {
            if (optionRows.length < 2) {
                optionRemoveButton.classList.add("d-none");
                return;
            } else {
                optionRemoveButton.classList.remove("d-none");
            }
        });
    }
    function deleteOptionRow(e) {
        let optionRow = this.closest(".option-row");
        optionRow.remove();
        showHideOptionRemoveButtons();
    }

    let submit = document.getElementById("submit");
    if (submit != null) {
        submit.addEventListener("click", function () {
            let form = document.getElementById("question-form");
            let formData = new FormData(form);
            let sub_category = document.getElementById("sub_category");
            let sub_category_id = sub_category.value;
            formData.append("sub_category_id", sub_category_id);
            let url = `${question_url}/store`;
            let form_type = document.getElementById("form_type").value;
            let message = "Question added successfully";
            if (form_type == "edit") {
                let question_id = document.getElementById("question_id").value;
                formData.append("id", question_id);
                url = `${question_url}/update`;
                message = "Question updated successfully";
            }
            axios
                .post(url, formData)
                .then(function (response) {
                    if (response.data.success) {
                        swal.fire("Success", message, "success").then(
                            function () {
                                let modal = bootstrap.Modal.getInstance(
                                    document.getElementById("myModal")
                                );
                                modal.hide();
                                getQuestions(sub_category_id);
                            }
                        );
                    } else {
                        swal.fire("Error", response.data.message, "error").then(
                            function () {
                                getQuestions(sub_category_id);
                            }
                        );
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        });
    }

    function getQuestions(subcategory_id) {
        let token = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        let url = `${question_url}/show`;
        return axios
            .post(url, {
                subcategory_id: subcategory_id,
                _token: token,
            })
            .then(function (response) {
                let question_section =
                    document.getElementById("question-section");
                question_section.innerHTML = response.data.html;
                loadScripts();
            });
    }
}
