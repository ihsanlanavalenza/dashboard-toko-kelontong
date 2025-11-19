            </div>
            </div>
            </div>

            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
            <!-- DataTables -->
            <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

            <script>
                // Initialize DataTables
                $(document).ready(function() {
                    $('.datatable').DataTable({
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                        },
                        pageLength: 10,
                        responsive: true
                    });
                });

                // Format Rupiah
                function formatRupiah(angka) {
                    return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }

                // Confirm Delete
                function confirmDelete(message) {
                    return confirm(message || 'Apakah Anda yakin ingin menghapus data ini?');
                }

                // Toast Notification
                function showToast(message, type = 'success') {
                    const toast = document.createElement('div');
                    toast.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
                    toast.style.zIndex = '9999';
                    toast.innerHTML = message;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
            </script>
            </body>

            </html>