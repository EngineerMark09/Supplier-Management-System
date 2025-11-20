$(document).ready(function() {
    
    // Load suppliers on page load
    loadSuppliers();
    loadSuppliersTab();

    // Tab Navigation
    $('.nav-link[data-tab]').click(function(e) {
        e.preventDefault();
        var tab = $(this).data('tab');
        
        // Update active state
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        
        // Show corresponding tab content
        $('.tab-content').removeClass('active');
        $('#tab-' + tab).addClass('active');
        
        // Update page title
        var titles = {
            'dashboard': 'Dashboard',
            'suppliers': 'Supplier Management',
            'settings': 'System Settings'
        };
        $('#page-title').text(titles[tab] || 'Dashboard');
        
        // Reload data if switching to suppliers tab
        if(tab === 'suppliers') {
            loadSuppliersTab();
        }
        
        // Update settings info if switching to settings
        if(tab === 'settings') {
            updateSettingsInfo();
        }
    });

    // Open Modal for Adding (Dashboard)
    $('#btn-add-supplier').click(function() {
        openSupplierModal();
    });

    // Open Modal for Adding (Suppliers Tab)
    $('#btn-add-supplier-tab').click(function() {
        openSupplierModal();
    });

    // Close Modal
    $('.close-modal, .close-modal-btn').click(function() {
        $('#supplier-modal').hide();
    });

    // Close modal when clicking outside
    $(window).click(function(event) {
        if (event.target.id == 'supplier-modal') {
            $('#supplier-modal').hide();
        }
    });

    // Handle Form Submission (Create & Update)
    $('#supplier-form').submit(function(e) {
        e.preventDefault();
        
        var id = $('#supplier_id').val();
        var url = id ? 'api/update.php' : 'api/create.php';
        var formData = {
            id: id,
            company_name: $('#company_name').val(),
            contact_person: $('#contact_person').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            address: $('#address').val()
        };

        $.ajax({
            url: url,
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
            success: function(response) {
                $('#supplier-modal').hide();
                $('#supplier-form')[0].reset();
                showAlert('success', response.message);
                loadSuppliers();
                loadSuppliersTab();
            },
            error: function(xhr, status, error) {
                var msg = xhr.responseJSON ? xhr.responseJSON.message : 'An error occurred';
                showAlert('error', msg);
            }
        });
    });

    // Handle Edit Button
    $(document).on('click', '.btn-edit', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: 'api/get_single.php?id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#supplier_id').val(data.id);
                $('#company_name').val(data.company_name);
                $('#contact_person').val(data.contact_person);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
                $('#address').val(data.address);
                
                $('#modal-title').text('Edit Supplier');
                $('#supplier-modal').css('display', 'flex');
            },
            error: function() {
                showAlert('error', 'Could not fetch supplier details.');
            }
        });
    });

    // Handle Delete Button
    $(document).on('click', '.btn-delete', function() {
        if(confirm('Are you sure you want to delete this supplier?')) {
            var id = $(this).data('id');
            
            $.ajax({
                url: 'api/delete.php',
                type: 'POST',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                success: function(response) {
                    showAlert('success', response.message);
                    loadSuppliers();
                    loadSuppliersTab();
                },
                error: function(xhr) {
                    var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Delete failed';
                    showAlert('error', msg);
                }
            });
        }
    });

    // Search Functionality
    $('#search-input').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#suppliers-table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Search Functionality (Suppliers Tab)
    $('#search-input-suppliers').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#suppliers-table-tab tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Functions
    function openSupplierModal() {
        $('#modal-title').text('Add Supplier');
        $('#supplier-form')[0].reset();
        $('#supplier_id').val('');
        $('#supplier-modal').css('display', 'flex');
    }

    function loadSuppliers() {
        $.ajax({
            url: 'api/read.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#system-status').text('Online').css('color', 'var(--success-color)');
                var rows = '';
                if(data.length > 0) {
                    $('#total-suppliers').text(data.length);
                    $.each(data, function(i, item) {
                        rows += `<tr>
                            <td>${item.id}</td>
                            <td>${item.company_name}</td>
                            <td>${item.contact_person}</td>
                            <td>${item.email}</td>
                            <td>${item.phone}</td>
                            <td>
                                <button class="btn-sm btn-edit" data-id="${item.id}"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn-sm btn-delete" data-id="${item.id}"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>`;
                    });
                } else {
                    $('#total-suppliers').text('0');
                    rows = '<tr><td colspan="6" style="text-align:center">No suppliers found.</td></tr>';
                }
                $('#suppliers-table tbody').html(rows);
            },
            error: function() {
                $('#system-status').text('Offline').css('color', 'var(--danger-color)');
                $('#suppliers-table tbody').html('<tr><td colspan="6" style="text-align:center; color:red;">Error loading data. Check database connection.</td></tr>');
            }
        });
    }

    function loadSuppliersTab() {
        $.ajax({
            url: 'api/read.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var rows = '';
                if(data.length > 0) {
                    $.each(data, function(i, item) {
                        rows += `<tr>
                            <td>${item.id}</td>
                            <td>${item.company_name}</td>
                            <td>${item.contact_person}</td>
                            <td>${item.email}</td>
                            <td>${item.phone}</td>
                            <td>${item.address}</td>
                            <td>
                                <button class="btn-sm btn-edit" data-id="${item.id}"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn-sm btn-delete" data-id="${item.id}"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>`;
                    });
                } else {
                    rows = '<tr><td colspan="7" style="text-align:center">No suppliers found.</td></tr>';
                }
                $('#suppliers-table-tab tbody').html(rows);
            },
            error: function() {
                $('#suppliers-table-tab tbody').html('<tr><td colspan="7" style="text-align:center; color:red;">Error loading data. Check database connection.</td></tr>');
            }
        });
    }

    function updateSettingsInfo() {
        $.ajax({
            url: 'api/read.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#db-status-settings').text('Connected').removeClass('badge-danger').addClass('badge-success');
                $('#total-records-settings').text(data.length);
            },
            error: function() {
                $('#db-status-settings').text('Disconnected').removeClass('badge-success').addClass('badge-danger');
                $('#total-records-settings').text('N/A');
            }
        });
    }

    function showAlert(type, message) {
        var alertBox = $('#alert-message');
        alertBox.removeClass('alert-success alert-error').addClass(type === 'success' ? 'alert-success' : 'alert-error');
        alertBox.text(message).fadeIn();
        setTimeout(function() {
            alertBox.fadeOut();
        }, 3000);
    }
});
