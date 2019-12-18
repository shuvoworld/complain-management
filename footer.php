		<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            var quill = new Quill('.editor', {
                theme: 'snow'
            });
            $(document).ready(function() {
                $('.select').select2({
                    theme: "classic",
                    width: '50%',
                });
            });
        </script>

        </div>
	</body>
</html>