<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xxl-7">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-primary">
                                        <i class="fas fa-list-alt"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total')); ?></p>
                                    <h6 class="mb-3"><?php echo e(__('Categories')); ?></h6>
                                    <h3 class="mb-0"><?php echo e($categories); ?></h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-info">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Open')); ?></p>
                                    <h6 class="mb-3"><?php echo e(__('Tickets')); ?></h6>
                                    <h3 class="mb-0"><?php echo e($open_ticket); ?> </h3>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-warning">
                                        <i class="fas fa-ticket-alt"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Closed')); ?></p>
                                    <h6 class="mb-3"><?php echo e(__('Tickets')); ?></h6>
                                    <h3 class="mb-0"><?php echo e($close_ticket); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="card">
                                <div class="card-body dash_card_height">
                                    <div class="theme-avtar bg-danger">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total')); ?></p>
                                    <h6 class="mb-3"><?php echo e(__('Agents')); ?></h6>
                                    <h3 class="mb-0"><?php echo e($agents); ?></h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Tickets by Category')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <div id="categoryPie"></div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('This Year Tickets')); ?></h5>
                        </div>
                        <div class="card-body">
                                        <form id="chartFilterForm" action="dashboard">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="filterProvince" class="form-label"><?php echo e(__('Select Province')); ?>:</label>
                                                    <select id="filterProvince" class="form-select" name="filterProvince">
                                                        <option value="" selected><?php echo e(__('All Provinces')); ?></option>
                                                        <?php $__currentLoopData = $provinces; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $province): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($province->id); ?>" <?php echo e($province->id == $request->input('filterProvince') ? 'selected' : ''); ?>>
                                                                <?php echo e($province->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filterCity" class="form-label"><?php echo e(__('Select City')); ?>:</label>
                                                    <select id="filterCity" class="form-select" name="filterCity">
                                                        <option value="" selected><?php echo e(__('All Cities')); ?></option>
                                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($city->id); ?>" <?php echo e($city->id == $request->input('filterCity') ? 'selected' : ''); ?>>
                                                                <?php echo e($city->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <!-- Sisanya tetap seperti sebelumnya -->
                                                <div class="col-md-3">
                                                    <label for="filterMonth" class="form-label"><?php echo e(__('Select Month')); ?>:</label>
                                                    <?php
                                                        $selectedMonth = isset($request) ? $request->input('filterMonth') : date('n');
                                                    ?>
                                                    <select id="filterMonth" class="form-select" name="filterMonth">
                                                        <!-- Daftar opsi bulan (1-12) -->
                                                        <?php for($i = 1; $i <= 12; $i++): ?>
                                                            <option value="<?php echo e($i); ?>" <?php echo e($i == (int)$selectedMonth ? 'selected' : ''); ?>>
                                                                <?php echo e(date('F', mktime(0, 0, 0, $i, 1))); ?>

                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="filterYear" class="form-label"><?php echo e(__('Select Year')); ?>:</label>
                                                    <select id="filterYear" class="form-select" name="filterYear">
                                                        <!-- Daftar opsi tahun (dari tahun sekarang hingga 5 tahun ke belakang) -->
                                                        <?php for($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                                                            <option value="<?php echo e($i); ?>" <?php echo e($i == date('Y') || $i == $request->input('filterYear') ? 'selected' : ''); ?>>
                                                                <?php echo e($i); ?>

                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Apply</button>
                                                </div>
                                            </div>

                                            
                                        </form>
                            <div id="chartBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('List Province Ticket')); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php if($tickets->isEmpty()): ?>
                                <p>No tickets found for the selected provinces.</p>
                            <?php else: ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Province</th>
                                            <th>Count</th>
                                            <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($ticket->id); ?></td>
                                                <td><?php echo e($ticket->province_name); ?></td>
                                                <td><?php echo e($ticket->ticket_count); ?></td>

                                                <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Category Ticket List')); ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Category')); ?></th>
                                        <th><?php echo e(__('On Hold')); ?></th>
                                        <th><?php echo e(__('In Progress')); ?></th>
                                        <th><?php echo e(__('Closed')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $categoriesChartTable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($category->name); ?></td>
                                            <td><?php echo e($category->on_hold_count); ?></td>
                                            <td><?php echo e($category->in_progress_count); ?></td>
                                            <td><?php echo e($category->closed_count); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Response Times -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('Response Time by Agents')); ?></h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('Agent')); ?></th>
                                        <th><?php echo e(__('Response Time')); ?></th>
                                        <th><?php echo e(__('Ticket Count')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $agentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($agent->agent_name); ?></td>
                                            <td><?php echo e($agent->total_response_time); ?> hours</td>
                                            <td><?php echo e($agent->ticket_count); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>

        <script>
            $(document).ready(function () {
                // Saat province berubah, ambil id province dan perbarui dropdown city
                $('#filterProvince').change(function () {
                    var selectedProvinceId = $(this).val();
                    updateCityDropdown(selectedProvinceId);
                });

                // Fungsi untuk memperbarui dropdown city
                function updateCityDropdown(selectedProvinceId) {
                    // Kirim AJAX request ke server untuk mendapatkan cities berdasarkan selectedProvinceId
                    $.ajax({
                        url: '<?php echo e(route("admin.get.cities.by.province")); ?>', // Gantilah dengan URL yang sesuai
                        method: 'GET',
                        data: { province_id: selectedProvinceId },
                        success: function (data) {
                            // Perbarui dropdown city dengan data baru
                            $('#filterCity').html('<option value="" selected><?php echo e(__("All Cities")); ?></option>');
                            $.each(data, function (key, value) {
                                $('#filterCity').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                }

                // Inisialisasi dropdown city saat halaman dimuat
                var selectedProvinceId = $('#filterProvince').val();
                updateCityDropdown(selectedProvinceId);
            });
        </script>

    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>
    <script>
        var arChart;  // Declare arChart as a global variable

        (function() {
            var chartBarOptions = {
                series: [{
                    name: '<?php echo e(__("Tickets")); ?>',
                    data: <?php echo json_encode(array_values($monthData)); ?>

                }],

                chart: {
                    height: 150,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: <?php echo json_encode(array_keys($monthData)); ?>,
                    title: {
                        text: '<?php echo e(__('Months')); ?>'
                    }
                },
                colors: ['#ffa21d', '#FF3A6E'],
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 4,
                    colors: ['#ffa21d', '#FF3A6E'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: '<?php echo e(__('Tickets')); ?>'
                    },
                    tickAmount: 3,
                    min: 10,
                    max: 70,
                }
            };
            arChart = new ApexCharts(document.querySelector("#chartBar"), chartBarOptions);
            arChart.render();
        })();
        (function() {
            var categoryPieOptions = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: <?php echo json_encode($chartData['value']); ?>,
                colors: <?php echo json_encode($chartData['color']); ?>,
                labels: <?php echo json_encode($chartData['name']); ?>,
                legend: {
                    show: true
                }
            };
            var categoryPieChart = new ApexCharts(document.querySelector("#categoryPie"), categoryPieOptions);
            categoryPieChart.render();
        })();


    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\helpdesk\resources\views/admin/dashboard/index.blade.php ENDPATH**/ ?>