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

function fixedMenu()
{
let beforeY=window.scrollY;
window.addEventListener("scroll",function()
{
let afterY=window.scrollY;
if(afterY>beforeY)
{
  
}
})
}

let create_post_btn=document.querySelector("#create-post");
let blog_content=document.querySelectorAll(".blog-content");
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


hideCreationForm();

create_post_btn.addEventListener("click",function()
{
blog_content.classList.add("d-none");
cancel_post_btn.style.display="block";
showCreationForm();
});

cancel_post_btn.addEventListener("click",function()
{
blog_content.classList.remove('d-none');
blog_content.classList.add('d-flex')
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
  })

   filterButton.addEventListener('click',(e)=>
  {
    e.preventDefault();

    const selectedCategories=
    Array.from(document.querySelectorAll("input.category-input:checked"))
    .map(checkbox=>checkbox.value);
    blog_content.forEach(content=>
    {

  });
  })









