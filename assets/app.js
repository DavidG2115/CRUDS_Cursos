import './bootstrap.js';
import 'datatables.net'
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-responsive';
import 'bootstrap-icons/font/bootstrap-icons.css'

import $ from 'jquery';


$(document).ready(function() {
    console.log("Document is ready!");

    const table = $('#employeeTableAPI').DataTable({
        ajax: '/employee/api',
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'email' },
            { data: 'courses' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <a href="/employee/${data}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="/employee/${data}/edit" class="btn btn-sm btn-primary "><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="bi bi-trash"></i></button>
                    `;
                }
            }
        ],
        columnDefs: [
            { orderable: false, targets: [4] }
        ],
        responsive: true,
        searching: true,
        ordering: true,
        pageLength: 3
    });

    $('#employeeTableAPI').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Are you sure you want to delete this employee?')) {
            fetch(`/employee/${id}/delete`, {
                method: 'DELETE',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' }
            })
            .then(response => {
                if(response.ok) {
                    table.row(row).remove().draw();
                } else {
                    alert('Error deleting employee');
                }
            });
        }
    });

//     Table for Courses
    const tableCourses = $('#coursesTable').DataTable({
        ajax: '/course/api',
        columns: [
            { data: 'id'},
            { data: 'name'},
            { data: 'description'},
            { data: 'duration'},
            { data: 'employees'},
            { data: 'trainers'},
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <a href="/course/${data}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="/course/${data}/edit" class="btn btn-sm btn-primary "><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="bi bi-trash"></i></button>
                    `;
                }
            }


        ],
        // order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [6] }
        ],
        responsive: true,
        searching: true,
        ordering: true,
        pageLength: 3

    });

    $('#coursesTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Are you sure you want to delete this employee?')) {
            fetch(`/course/${id}/delete`, {
                method: 'DELETE',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' }
            })
                .then(response => {
                    if(response.ok) {
                        tableCourses.row(row).remove().draw();
                    } else {
                        alert('Error deleting employee');
                    }
                });
        }
    });

    const tableTrainers = $('#trainersTable').DataTable({
        ajax: '/trainer/api',
        columns: [
            { data: 'id'},
            { data: 'name'},
            { data: 'email'},
            { data: 'course'},
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <a href="/trainer/${data}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="/trainer/${data}/edit" class="btn btn-sm btn-primary "><i class="bi bi-pencil-square"></i></a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="bi bi-trash"></i></button>
                    `;
                }
            }


        ],
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [4] }
        ],
        responsive: true,
        searching: true,
        ordering: true,
        pageLength: 3

    });

    $('#trainersTable').on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');

        if (confirm('Are you sure you want to delete this employee?')) {
            fetch(`/trainer/${id}/delete`, {
                method: 'DELETE',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json' }
            })
                .then(response => {
                    if(response.ok) {
                        tableTrainers.row(row).remove().draw();
                    } else {
                        alert('Error deleting trainer');
                    }
                });
        }
    });



});



/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
