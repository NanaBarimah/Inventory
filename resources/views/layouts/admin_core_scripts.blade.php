<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/now-ui-dashboard.min.js?v=1.2.0')}}" type="text/javascript"></script>
<script>
$('#notifications').on('click', function(){
    $.ajax({
            url : '/admin/markAsRead',
            method : 'get',  
            success : function(data, status, xhr){
                if(!data.error){
                    $('#notificationsCount').css('display', 'none');
                }
            },
            error : function(err, desc){
                console.log(err);
            }
        })
});
</script>