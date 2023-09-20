<?php
add_action('docSach_search', 'docSach_search');
function docSach_search()
{
    global $hosting;
?>
    <div class="col-sm-5 col-md-3">
        <form class="search-wrap">
            <div class="form-group">
                <input name="key_search" id="key_search" type="search" class="form-control search" placeholder="Search" required>
                <button onclick="serch()" class="btn btn-primary submit-search text-center" type="button">
                    <i class="icon-search"></i>
                </button>
            </div>
        </form>
    </div>
    <script>
        function serch() {
            var key_search = document.getElementById('key_search').value;
            jQuery.ajax({
                url: '<?php echo $hosting . "wp-admin/admin-ajax.php" ?>', // URL Ajax
                dataType: 'html',
                type: 'POST',
                data: {
                    action: 'search',
                    key_search: key_search,
                },
                success: function(response) {
                    console.log(response); // Xử lý kết quả thành công
                    location.href = '<?php echo $hosting . 'search/' ?>'

                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi
                }
            });
        }
    </script>
<?php
}
