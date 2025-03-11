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
}
});

///////////modification-container/////////////
const modification_container=document.querySelector('.modification-container');
const dot=document.querySelector('.modification-container::before');
const add_image=document.querySelector('.add-image');
const delete_image=document.querySelector('.delete-image');
const edit_image=document.querySelector('.edit-image');
const view_image=document.querySelector('.view-image');

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
     ADD_FORM();
     return;
    }
   if(!checkColor(color) )
      {
        defineColor(color);
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
     return;
    }
   if(!checkColor(color) )
      {
        defineColor(color);
        return;     
      }
   modification_container.classList.add("d-none");
     
});



edit_image.addEventListener('click',()=>
{
  color="yellow";
  if(modification_container.classList.contains("d-none"))
    {
     modification_container.classList.remove('d-none');
     defineColor(color);
     return;
    }
   if(!checkColor(color) )
      {
        defineColor(color);
        return;     
      }
   modification_container.classList.add("d-none");
      
});

view_image.addEventListener('click',()=>
{
  const color="cyan";
  if(modification_container.classList.contains("d-none"))
    {
     modification_container.classList.toggle('d-none');
     defineColor(color);
     return;
    }
   if(!checkColor(color) )
      {
        defineColor(color);
        return;     
      }
   modification_container.classList.add("d-none");
     
});
/////////////////modifications forms///////////////////
function ADD_FORM()
{
console.log("ADD_FORM function called");
const add_image_form=document.createElement("form");
const file_button=document.createElement("button");
const icon=document.createElement("i");

file_button.type="file";
icon.classList.add("fa-solid","fa-circle-arrow-up");
add_image_form.style.background="transparent";
file_button.style.width="fit-content";
file_button.style.height="fit-content";
file_button.style.display = "flex";
file_button.style.alignItems = "center";
file_button.style.justifyContent = "center";
file_button.style.background="transparent";
file_button.style.border="none";
icon.style.flex="100%";
icon.style.scale="5";


file_button.appendChild(icon);
add_image_form.appendChild(file_button);
modification_container.appendChild(add_image_form);
}
  }









