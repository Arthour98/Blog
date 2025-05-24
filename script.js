let loading_screen=document.getElementById('loading-screen');

document.addEventListener("DOMContentLoaded",function()
{
if(document.readyState==="complete");
{
setTimeout(()=>{
loading_screen.style.display="none";
},500);
}
});

let tooltipTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltips=tooltipTriggerList.map(function(tooltipTriggerEl)
{
return new bootstrap.Tooltip(tooltipTriggerEl);
});

let menu=document.querySelector(".menu");

let body=document.body;
let page=window.location.pathname;













if(page.endsWith("index.php"))
  {
  body.style.backgroundImage="url('/images/backgound-forum.jpeg')";
  
let create_post_btn=document.querySelector("#create-post");
let blog_content=document.querySelectorAll("#blog-content");
let cancel_post_btn=document.querySelector("#cancel-post");
let form_post_blog=document.querySelector("#creation-post");

function hideCreationForm()
{
form_post_blog.classList.remove('d-flex');
form_post_blog.classList.add('d-none');
}
function showCreationForm()
{
form_post_blog.classList.remove('d-none');
form_post_blog.classList.add('d-flex');
}

create_post_btn.addEventListener("click",function()
{
cancel_post_btn.style.display="block";
showCreationForm();
});

cancel_post_btn.addEventListener("click",function()
{
cancel_post_btn.style.display="none";
hideCreationForm();
})


// hide alert onscroll*//
let myAlert=document.getElementById("alert");


function AlertNone(alert)
{
alert.style.display="none";
}

let bodyContent=document.getElementById("body-content");

if(myAlert)
{
window.addEventListener("wheel",function()
{
        console.log("Scoll is happening");
        AlertNone(myAlert);
  
});
}

//*show-comments*

const comment_btn=document.querySelectorAll("p.comments");
const comment_row=document.querySelectorAll('div#comment-row');

comment_btn.forEach((btn,index)=>btn.addEventListener("click",function()
{
setTimeout(()=>
comment_row[index].classList.toggle("d-none"),300
)
}
));


//*post-settings*
const settings_button=document.querySelectorAll("i.post-settings");
const settings_menu=document.querySelectorAll('form.settings-menu');
function toggleMenu()
{
settings_button.forEach((button,index)=>
{
button.addEventListener("click",function()
{
settings_menu[index].classList.toggle("d-none");
})
})
}
toggleMenu();



//orizw tis metavlhtes pou 8a xrhsimopoihsw gia to EDIT functionality
const edit_button=document.querySelectorAll('input[type=submit].edit');
let isEditing = [];
let content = document.querySelectorAll("p.content-text");
let contentByUser=[];
let content_container=document.querySelectorAll('.content-container');    
let edit_submit=document.querySelectorAll('input.EDIT_SUBMIT');
let edit_text=document.querySelectorAll("textarea.EDIT_TEXT");
let edit_id=document.querySelectorAll("input.EDIT_ID");
//////

//edw grafw mia constructor function gia thn diadikasia ths edit leitourgias //
function edit(content,edit_form,isEditing, button) {
  this.content = content;
  this.isEditing = isEditing;
  this.button = button;
  this.edit_form=edit_form;
  this.execute = function() {
    if (this.isEditing === false)
    {
      this.isEditing=true;
      this.content.style.display="none";
      this.edit_form.classList.toggle('d-none')
      this.button.classList.add("bg-secondary");
      this.button.value="CANCEL";
    } else {
      this.edit_form.classList.toggle('d-none');
      this.content.style.display="flex";
      this.button.classList.remove('bg-secondary');
      this.button.value="EDIT";
      this.isEditing = false;
    }
  }

  }

  ////////////

  //edw vazw to content tou user se array gia na to epe3ergastw meta//
  for(let i=0;i<content.length;i++)
  {
  let users_content_attr=content[i].getAttribute("data-user-id");
  if(users_content_attr)
  {
  contentByUser.push(content[i]);
  }
  else continue;
  }
  /////

///edw dhmiourgw click event gia to edit koubi opou to isEditing[index] property elenxei einai se edit mode h oxi 
///edw xrhsimopoiw to contentByUser array pou eftia3a prin gia na peira3w to keimeno tou Post tou user kai oxi kapio allo
// Dhladh to eftia3a etsi gia Indexing logous !
let edit_form=document.querySelectorAll('form.EDIT_FORM');


edit_button.forEach((button, index) => {
  isEditing[index] = false;
  button.addEventListener("click", function(e)
{
e.preventDefault();  
let editing = new edit(contentByUser[index],edit_form[index],isEditing[index],button);
  editing.execute();
  isEditing[index] = editing.isEditing;
  console.log(contentByUser);


       
})
});
//////////////////////////
//edw dhmiourgw ajax request gia na steilw asunxrona ta data ston server
edit_submit.forEach((button,index)=>
  {
    
  button.addEventListener('click',function(e)
{
  e.preventDefault();

  if (isEditing[index] === true) {
    let editing = new edit(contentByUser[index], edit_form[index], isEditing[index], edit_button[index]);
    editing.execute();
    isEditing[index] = editing.isEditing;
  }

  let content=edit_text[index].value;
  let content_id=edit_id[index].value;
  
  
  let editData=new FormData();
  editData.append("edited-content",content);
  editData.append("post-id",content_id);
  fetch('blog-exec/edit.php',
    {
      method:"POST",
      body:editData
   })
      .then(response=>{
        console.log(response);
        return response.json()})
      .then(data=>
      {
      if(data.success)
      {
        contentByUser[index].innerHTML=content;
        console.log(data);
      }})
  })
  })
  ///////////////////////////////

  //filtro//
  
   
   const filterButton=document.getElementById('filter');
   const resetButton=document.getElementById('reset');

   resetButton.addEventListener("click",(e)=>
  {
  e.preventDefault();

  const selectedCategories=
  Array.from(document.querySelectorAll("input.category-input:checked"))
  .map(checkbox=>checkbox.checked=false);
  


  blog_content.forEach(content=>
  {
    if(content.classList.contains("d-none"))
      {
        content.classList.remove("d-none");
        content.style.scale=0;
        content.style.filter="blur(6px)";
      }

      let scale=0;
      let blurEffect=parseFloat(getComputedStyle(content)
      .filter.match(/blur\((\d+\)px)/)?.[1]||6);
    function animate()
    {
     if(scale<1 || blurEffect>0)
     {
      scale+=0.01;
      blurEffect-=0.08;
      content.style.scale=`${scale}`;
      content.style.filter=`blur(${blurEffect}px)`;
      requestAnimationFrame(animate);
     }}
animate();
})

  })

   filterButton.addEventListener('click',(e)=>
  {
    e.preventDefault();

    const selectedCategories=
    Array.from(document.querySelectorAll("input.category-input:checked"))
    .map(checkbox=>checkbox.value);

    blog_content.forEach(blog=>
    {
    blog.classList.add("d-none");
    blog.style.filter="blur(6px)";
    blog.style.scale="0"})
   
    
    for(let i=0;i<blog_content.length;i++)
    {
    if(selectedCategories.includes(blog_content[i].getAttribute("data-categorized")))
    {
      blog_content[i].classList.remove("d-none");
      let scale=0;
      let blurEffect=parseFloat(getComputedStyle(blog_content[i])
      .filter.match(/blur\((\d+)px\)/)?.[1] || 6);
     function animate(){
      if(scale<1 || blurEffect>0)
      {
        scale+=0.01;
        blurEffect-=0.08;

        scale = Math.min(scale, 1);
        blurEffect = Math.max(blurEffect, 0);

        blog_content[i].style.scale=`${scale}`;
        blog_content[i].style.filter=`blur(${blurEffect}px)`;
        requestAnimationFrame(animate);
      }
      
    }
        
        animate();   
  }}})
  }
////////////Gallery////////
/////menu-options/////////
if(page.endsWith("gallery.php"))
  {
  body.style.backgroundImage="url('/images/background-gallery.jpeg')";
  body.style.backgroundSize="cover";
  body.style.backgroundRepeat="no-repeat";
  
  
const menu_options=document.querySelector("#menu-options");
const hamburger=document.querySelector('.menu-icon');

hamburger.addEventListener('click',()=>
{
menu_options.classList.toggle('w-50');
menu_options.classList.toggle('w-0');
if(menu_options.classList.contains("w-50"))
{
  hamburger.classList.replace("fa-bars","fa-circle-xmark");
}
else
{
  hamburger.classList.replace("fa-circle-xmark","fa-bars");
  setTimeout(()=>{
  modification_container.classList.add('d-none');
  },1000);
}
});

///////////modification-container/////////////
const modification_container=document.querySelector('.modification-container');
const dot=document.querySelector('.modification-container::before');
const add_image=document.querySelector('.add-image');
const delete_image=document.querySelector('.delete-image');
const add_container=document.querySelector(".adding-container");
const delete_container=document.querySelector(".delete-container");

function defineContainer(color)
{
 container=[add_container,delete_container];
  switch(color)
  {
    case "green":add_container.classList.remove("d-none");
                  delete_container.classList.add("d-none");
                  break;
    case "red":add_container.classList.add("d-none");
              delete_container.classList.remove("d-none");
              break;
  }}  

function defineColor(color)
{
  modification_container.style.setProperty("--border-color",color);
  modification_container.style.setProperty("--dot-color",color)
}
function checkColor(color)
{
const val=getComputedStyle(modification_container).getPropertyValue("--border-color");
if(val===color)
{
  return true;
}
}

add_image.addEventListener('click',()=>
{
  const color="green";
  
  if(modification_container.classList.contains("d-none"))
    {
     modification_container.classList.remove('d-none');
     defineColor(color);
     defineContainer(color)
     return;
    }
   if(!checkColor(color) )
      {
        defineColor(color);
        defineContainer(color)
        return;     
      }
   modification_container.classList.add("d-none");

});



delete_image.addEventListener('click',()=>
{
  const color="red";
  if(modification_container.classList.contains("d-none"))
    {
     modification_container.classList.remove('d-none');
     defineColor(color);
     defineContainer(color)
     return;
    }
   if(!checkColor(color) )
      {
        defineColor(color);
        defineContainer(color)
        return;     
      }
   modification_container.classList.add("d-none");
     
});





/////////////////delete_mod///////////////////
const image_input=document.getElementById("image-input");

image_input.addEventListener('change',(e)=>
{
let file=e.target.files[0];
if(file)
{
let reader=new FileReader();
let image_placeholder=document.getElementById("image-for-adding");
reader.onload=function(ev)
{
image_placeholder.src=ev.target.result;
}
reader.readAsDataURL(file);
}
});

const delete_placeholder=document.getElementById("delete-placeholder");
const gallery_images=document.querySelectorAll(".gallery-images");
function Allow_drop(event)
{
  event.preventDefault();
  event.dataTransfer.dropEffect="copy";
}

function getContent(event)
{
  
  let data=event.dataTransfer.getData("image");
  let DraggedElem=document.getElementById(data);
  let clonedElem=DraggedElem.cloneNode();
  event.target.appendChild(clonedElem);

}

function setContent(event)
{
event.dataTransfer.setData("image",event.target.id);
event.dataTransfer.effectAllowed = "copy";
}

gallery_images.forEach(image=>
{
image.addEventListener("dragstart",setContent);
});
delete_placeholder.addEventListener("dragover",Allow_drop);
delete_placeholder.addEventListener("drop",getContent);


if(delete_container)
{
 async function getImageATTR()
 {
  let img ;
  while(!img)
  {
    img = delete_placeholder?.querySelector("img")
    if(img)
    {
      return img.getAttribute("data-image-id");
    }
    await new Promise(resolve => setTimeout(resolve, 1000));
 }}

(async()=>
{
  const image=await getImageATTR();

  if(image)
  {
  const input_delete=document.querySelector("form#delete_image input[type=hidden]");
  input_delete.value=image;
  }
})();
}
///////////panel/////////////
let target_image=document.getElementById('target-image');
target_image.src=null;
gallery_images.forEach(image=>
{
image.addEventListener('click',()=>
{
let image_id=image.getAttribute("data-image-id");
let like_image_id=document.getElementById('like-input');
let dislike_image_id=document.getElementById('dislike-input');
let commentary_id=document.getElementById("image_commentary_id");
const comment_container=document.getElementById("target-comments");
let comment_count_context=document.getElementById('comment_count');
comment_count_context.textContent="Comments:";

console.log(image_id);
fetch('api/getComments.php',
  {
    method:"POST",
    headers:
    {
    "Content-Type":"application/x-www-form-urlencoded"
    },
    body:JSON.stringify({"image_id":image_id})
    }
).then(response=>
{ 
return response.json();
})
.then(data=>
{
comment_container.replaceChildren();
target_image.src=data[0]["image_name"];
commentary_id.value=data[0]["image_id"];
dislike_image_id.setAttribute('value',data[0]["image_id"]);
like_image_id.setAttribute('value',data[0]["image_id"]);
target_image.setAttribute("data_img_id",data[0]["image_id"]);

data.forEach(elem=>
{
let row=document.createElement('div');
let userP=document.createElement('p');
let commentP=document.createElement('p');

row.classList.add("comments-row","d-flex","align-items-start","text-break",
  "gap-5","border-bottom","border-light");
commentP.textContent=elem["comment_text"];
userP.textContent=elem["user_name"];
commentP.classList.add("flex-33");
row.appendChild(userP);
row.appendChild(commentP);
comment_container.appendChild(row);
})
let comment_count=document.getElementById("target-comments").querySelectorAll('div').length;
const toggle_comments_button=document.getElementById("toggle-comments");
let comments=document.querySelectorAll('#target-comments > div');
let allComments=false;
comment_count_context.textContent+=comment_count.toString();
getStatus();
function hidecomments()
{
toggle_comments_button.innerText="Show more";
comments.forEach((comment,index)=>
{
if(index<5)
{
comment.classList.remove('d-none');
}
else
{
comment.classList.add("d-none");
}

})}


function showAllComments()
{
allComments=true;
toggle_comments_button.innerText="Show less";

comments.forEach(comment=>
{
comment.classList.remove("d-none");
})}

hidecomments();
toggle_comments_button.addEventListener("click",function()
{
if(allComments)
{
hidecomments();
allComments=false;
}
else if(!allComments)
{
  showAllComments();
}
})
});
})
});

const like_form=document.getElementById("gallery-like-form");
const dislike_form=document.getElementById("gallery-dislike-form");
const likes=document.getElementById('likes');
const dislikes=document.getElementById("dislikes");

function getStatus()
{
let img= document.getElementById("target-image");
let img_id=img.getAttribute('data_img_id');
fetch("api/getStatus.php",
  {
    method:"POST",
    headers:{"Content-Type":"application/x-www-form-urlencoded"},
    body:JSON.stringify({image_id:img_id})
  }).then(response=>{return response.json()})
  .then(data=>{
    console.log(data["likes"])
    likes.textContent=data["likes"];
    dislikes.textContent=data["dislikes"];
  })

}

like_form.addEventListener("submit",function(e)
{
  e.preventDefault();
  let user_id=document.getElementById("user-l-input").value;
  let image_id=document.getElementById("like-input").value;
  let status=document.getElementById("like-status").value;
  const formObj={user_id:user_id,image_id:image_id,status:status};
  console.log(formObj);
  fetch("api/gallery-like.php",
    {
      method:"POST",
      headers:{"Content-Type":"application/json"},
      body:JSON.stringify(formObj)
    }
  ).then(response=>
  {
    return response.json();
  })
  .then(
    data=>
    {
      likes.textContent=data["likes"];
      dislikes.textContent=data["dislikes"];
      console.log(data);
    }
  )
})
dislike_form.addEventListener("submit",function(e)
{
  e.preventDefault();
  let user_id=document.getElementById("user-d-input").value;
  let image_id=document.getElementById("dislike-input").value;
  let status=document.getElementById("dislike-status").value;
  const formObj={user_id:user_id,image_id:image_id,status:status};
  fetch("api/gallery-dislike.php",
    {
      method:"POST",
      headers:{"Content-Type":"application/json"},
      body:JSON.stringify(formObj)
    }).then(response=>
    {
      return response.json();
    })
    .then(data=>{
      likes.textContent=data["likes"];
      dislikes.textContent=data["dislikes"];
      console.log(data);
    })
})
  }






