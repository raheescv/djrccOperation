@if(session()->has('error'))
<script type="text/javascript">
	$(document).ready(function() { toastr.error("{{ session()->get('error') }}",'Error'); });
</script>
@endif
@if(session()->has('message'))
<script type="text/javascript">
	$(document).ready(function() { toastr.success("{{ session()->get('message') }}",'success'); });
</script>
@endif
@foreach($errors->all(':message') as $message)
<script type="text/javascript">
	$(document).ready(function() { toastr.error("{{ $message }}",'Error'); });
</script>
@endforeach()