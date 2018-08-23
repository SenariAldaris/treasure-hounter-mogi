<div id="photo_view_{id}" class="photo_view" onClick="Photo.setEvent(event, '{close-link}')">
  <div class="photo_close" onClick="Photo.Close('{close-link}'); return false;"></div>
  <div class="photo_bg" style="margin-top:50px;"> [all]
    <a href="/photo{uid}_{prev-id}{section}" onClick="Photo.Show(this.href); return false">
    <div class="photo_prev_but"></div>
    </a>
    <a href="/photo{uid}_{next-id}{section}" onClick="Photo.Show(this.href); return false">
    <div class="photo_next_but"></div>
    </a>
    [/all]
    <div id="distinguishSettings{id}" class="distinguishSettings" style="display:none" onMouseOver="Distinguish.HideTag({id})">
      <div style="position:absolute;border-right:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_left{id}"></div>
      <div style="position:absolute;border-bottom:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_top{id}"></div>
      <div style="position:absolute;border-left:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_right{id}"></div>
      <div style="position:absolute;border-top:3px solid #dbe6f0;cursor:default" id="distinguishSettingsBorder_bottom{id}"></div>
      <div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_left{id}"></div>
      <div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_top{id}"></div>
      <div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_right{id}"></div>
      <div style="position:absolute;cursor:default" class="imgareaselect-outer" id="distinguishSettings_bottom{id}"></div>
    </div>
    <a href="/photo{uid}_{next-id}{section}" onClick="[all]Photo.Show(this.href)[/all][wall]Photo.Close('{close-link}')[/wall]; return false" id="photo_href">
    <div class="photo_img_box" align="center">
    <img id="ladybug_ant{id}" class="ladybug_ant" src="{photo}" style="max-width:770px;" alt="" /></a>
  </div>
  <div class="photo_rightcol">
    <div class="alb_name">{author}
      <a href="/albums/view/{aid}" class="fl_r" style="font-weight:normal; font-size:12px;" onClick="Page.Go(this.href); return false">{translate=lang_158}</a>
    </div>
    <span style="color:#888">{author-info}</span>
    <div class="photo_info">{date}</div>
    <div  style="border-bottom:1px solid#464646; margin-top:5px;width:209px;  border-top:1px solid#787878"></div>
    <div class="menuleft" style="width:209px;"> [owner]
      <a href="/" id="send_ava" onClick="crop.start({id}); return false">
      <div>{translate=lang_171}</div>
      </a>
      <a href="/" id="edit_photo" onClick="Photo.EditBox({id}, 0); return false">
      <div>{translate=lang_172}</div>
      </a>
      <a href="/" id="delete_photo" onClick="Photo.MsgDelete({id}, {aid}, 1); return false">
      <div>{translate=lang_173}</div>
      </a>
      [/owner]
      <a id="photo_report" onClick="Report.Box('photo', '{id}')">
      <div>{translate=lang_174}</div>
      </a>
    </div>
    <div style="border-bottom:1px solid#464646; margin-top:1px; width:209px; border-top:1px solid#787878"></div>
    <div id="pinfo_{id}" class="pinfo">
      <div class="photo_leftcol">
        <input type="hidden" id="i_left{id}" />
        <input type="hidden" id="i_top{id}" />
        <input type="hidden" id="i_width{id}" />
        <input type="hidden" id="i_height{id}" />
        [all-comm]
        <a href="/" onClick="comments.all({id}, {num}); return false" id="all_href_lnk_comm_{id}">
        <div class="photo_all_comm_bg" id="all_lnk_comm_{id}" style="width:196px;">{translate=lang_166} {comm_num}</div>
        </a>
        <span id="all_comments_{id}"></span>[/all-comm] <span id="comments_{id}">{comments}</span> [add-comm]
        <div class="photo_com_title">{translate=lang_167}</div>
        <textarea id="textcom_{id}" class="inpst fl_l" style="width:200px; color:#fff; border:0px;height:30px;-moz-border-radius: 2px ;-webkit-border-radius: 2px ;border-radius: 2px;-moz-background-clip: padding;-webkit-background-clip: padding-box;background-clip: padding-box;background-color: #464646;-moz-box-shadow: 0 0 1px rgba(0,0,0,.5), inset 0 0 5px rgba(0,0,0,.5);-webkit-box-shadow: 0 0 1px rgba(0,0,0,.5), inset 0 0 5px rgba(0,0,0,.5);box-shadow: 0 0 1px rgba(0,0,0,.5), inset 0 0 5px rgba(0,0,0,.5);"></textarea>
        <div class="button_div fl_l" style="margin-top:5px;">
          <button id="add_comm" style="width:210px;" onClick="comments.add({id}); return false">{translate=lang_801}</button>
        </div>
        [/add-comm] </div>
    </div>
  </div>
  <div class="clear"></div>
  <div id="save_crop_text{id}" class="save_crop_text no_display" style="padding:10px; width:760px; margin-top:0px;"> {translate=lang_162}
    <div class="button_div_gray margin_left fl_r" style="margin-top:-5px;">
      <button onClick="crop.close({id}); return false">{translate=lang_163}</button>
    </div>
    <div class="button_div fl_r" style="margin-top:-5px">
      <button onClick="crop.save({id}, {uid}); return false">{translate=lang_164}</button>
    </div>
  </div>
  <div class="clear"></div>
</div>
