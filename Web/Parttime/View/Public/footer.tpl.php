
				</div><?php /* .data */?>
			</div><?php /* .main */?>
		</div><?php /* .body */?>
	</div><?php /* .container */?>
<script>
$(function(){
	//菜单
	$('.p').on('click', function(){
		var t = $(this);
		if (t.hasClass('active')){
			location.href = t.children('a').attr('href');
			return false;
		}
		$('.p').removeClass('active');
		$('.sub').hide();
		t.addClass('active');
		t.nextUntil('.p').show();
		return false;
	});
	$('li.active').nextUntil('.p').show();
	//日期选择
	if($('input[data-toggle="datetimepicker"]').length > 0){
		$('input[data-toggle="datetimepicker"]').datepicker();
	}
	//人员输入联想
	$('.typeahead').typeahead({
		source : function(query, process){
			$.getJSON('/User/searchUser', {name:query}, function(data){
				if (data.code == 0){
					process(data.data);
				}else{
					process([]);
				}
			});
		}
	});
	//操作按钮
	$('.btn-op').click(function(){
		var t = $(this);
		var confirmInfo = t.attr('confirm');
		if (confirmInfo){
			if (!confirm(confirmInfo)){
				return false;
			}
		}
		var after = t.attr('after');
		$.post(t.attr('href'), t.data(), function(data){
			if (data.code == 0){
				if (after == 'hide'){
					t.parent().parent().remove();
				}else if (after == 'refresh'){
					location.reload();
				}
			}else{
				alert(data.message);
			}
		}, 'json');
		return false;
	});
});
</script>
</body>
</html>