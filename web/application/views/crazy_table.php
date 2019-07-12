<!html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
var crazy_table_obj = {
    theadCntr: function (){
        var self = this;
        $(".thAdd").on("click", function (){
            var thead_cnt = $("thead").find("td").length;
            $(this).parent().parent().append("<td><input type='text' name='' value='"+thead_cnt+"' /></td>");
        });
    },
    tbodyCntr: function (){
        var self = this;

        //item 추가
        $(document).on("click", ".tbAdd", function (){
            var tbody_cnt = $(this).parent().parent().find("td").length;
            $(this).parent().parent().append("<td><input type='text' name='' value='"+tbody_cnt+"' /></td>");
        });

        //row 추가
        $(document).on("click", ".thRowAdd", function (){
            $(".rowClone  tr").clone().appendTo(".crazy tbody");
        });

        //row 삭제
        $(document).on("click", ".thRowDel", function (){
          $(this).parent().parent().remove();
        });
        
    },
    run: function () {        
        var self = this;
        self.theadCntr();
        self.tbodyCntr();
    }
}

$(function () {
    crazy_table_obj.run();
});

</script>
</head>

<body>


<table class="table crazy">
  <thead>
    <tr>
      <th scope="col"><span class="border border-primary thAdd">추가</span><span class="border border-primary thRowAdd">행추가</span></th>
      <th scope="col">First</th>
      <td scope="col">Last</td>
      <td scope="col">Handle</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><span class="border border-primary tbAdd">추가</span><span class="border border-primary thRowDel">행삭제</span></th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row"><span class="border border-primary tbAdd">추가</span><span class="border border-primary thRowDel">행삭제</span></th>
      
      <td>Thornton</td>
      <td>@fat</td>
    </tr>    
  </tbody>
</table>


<div>
<table class='rowClone'>
<tr>
<th scope="col"><span class="border border-primary tbAdd">추가</span><span class="border border-primary thRowDel">행삭제</span></th>
</tr>
</table>
</div>


<!-- Split dropright button -->
<div class="btn-group dropright">
  <button type="button" class="btn btn-secondary">
    Split dropright
  </button>
  <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="sr-only">Toggle Dropright</span>
  </button>
  <div class="dropdown-menu">
    <!-- Dropdown menu links -->
    <a class="dropdown-item" href="#">Action</a>
  </div>
</div>
</body>
</html>
