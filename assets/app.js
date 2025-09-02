import './bootstrap.js';
import 'datatables.net'
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-responsive';

import $ from 'jquery';


$(document).ready(function() {
    // ...otros DataTables...
    console.log("Document is ready!");

    // Guarda la instancia de DataTable en una variable
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
                        <a href="/employee/${data}/edit" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">Delete</button>
                    `;
                }
            }
        ],
        order: [[3, 'asc']],
        responsive: true,
        searching: true,
        ordering: true,
        pageLength: 3
    });

    // Usa la variable table aquí
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
});



/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import './employee.js'