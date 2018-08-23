<div class="wallrecord comm_wr" id="comment_{id}" style="width:220px;margin-top:5px;  border-top:1px solid#5e5e5e">
  <div class="ava_mini" onClick="Page.Go('/u{uid}'); return false" style="float:left; cursor:pointer;width:50px; margin-top:5px;"><img src="{ava}" style="-moz-box-shadow: 0 0 5px rgba(0,0,0,.75), inset 0 1px 5px rgba(255,255,255,.75);
-webkit-box-shadow: 0 0 5px rgba(0,0,0,.75), inset 0 1px 5px rgba(255,255,255,.75);
box-shadow: 0 0 5px rgba(0,0,0,.75), inset 0 1px 5px rgba(255,255,255,.75); border-radius:50px; width:40px;"
 /></div>
  <div style="float:left;width:160px;word-wrap:break-word; margin-left:-10px; ">
    <div class="wallauthor">
      <a href="/u{uid}" style="color:#45d216" onClick="Page.Go(this.href); return false">{author}</a>
    </div>
    <div class="walltext" style="color:#bebebe"> {comment}</div>
    <div class="infowalltext">{date} [owner]&nbsp;|&nbsp;
      <a href="/" style="color:#45d216" onClick="comments.delet({id}, '{hash}'); return false" id="del_but_{id}">{translate=lang_37}</a>
      [/owner]</div>
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>
