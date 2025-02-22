var sideBarIsOpen = true;
toggleBtn.addEventListener('click', (event) => {

event.preventDefault();
if (sideBarIsOpen) 
{
    dashboard_sidebar.style.width = '10%';
    dashboard_sidebar.style.transition = '0.3s all';
    dasboard_content_container.style.width = '90%';
    dashboard_logo.style.fontSize = '25px';
    userImage.style.width = "60px";
    menuIcons = document.getElementsByClassName('menuText');
    for (var i = 0; i < menuIcons.length; i++)
    {
        menuIcons[i].style.display = 'none';
    }
    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'center';
    sideBarIsOpen = false;
}
else 
{
    dashboard_sidebar.style.width = '10%';
    dasboard_content_container.style.width = '90%';
    dashboard_logo.style.fontSize = '25px';
    userImage.style.width = "60px";
    menuIcons = document.getElementsByClassName('menuText');
    for (var i = 0; i < menuIcons.length; i++) 
    {
        menuIcons[i].style.display = 'inline-block';
    }
    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign = 'normal';
    sideBarIsOpen = true;
}
}); 


//SubMenu show /hide function.
document.addEventListener('click',function(e)
{
    let clickedE1 = e.target;
    if(clickedE1.classList.contains('showHideSubMenu'))
    {
        let subMenu = clickedE1.closest('li').querySelector('.subMenus');
        let mainMenuIcon = clickedE1.closest('li').querySelector('.mainMenuIconArrow');

        //close open submenu
        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub)=>{
            if(subMenu !== sub)
            {
              sub.style.display='none';
            }
        });
        
        

        //call function to hide/show sideMenu
        showHideSubMenu(subMenu,mainMenuIcon);
       
    }
    
});
// fuction to show/hide submenu
function showHideSubMenu(subMenu,mainMenuIcon)
{
    if(subMenu != null)
    {
        if(subMenu.style.display==='block') 
        {
            subMenu.style.display='none';
            mainMenuIcon.classList.remove('fa-angle-down');
            mainMenuIcon.classList.add('fa-angle-left');
        }
        else
        {
           subMenu.style.display = 'block';
           mainMenuIcon.classList.remove('fa-angle-left');
            mainMenuIcon.classList.add('fa-angle-down');
        }
    }  
}

//Add / Hide active class to menu
// Get the current page
// use selector to get the current menu or sidemenu
// Add the active class

let pathArray = window.location.pathname.split('/');
let curfile = pathArray[pathArray.length - 1];

let curNav = document.querySelector('a[href="./'+curfile+'"]');
curNav.classList.add('subMenuActive');
let mainNav = curNav.closest('li.liMainMenu');
mainNav.style.background = '#f4f4f9';

let subMenu = curNav.closest('.subMenus');
let mainMenuIcon = mainNav.querySelector('i.mainMenuIconArrow');
console.log(subMenu)
 //call function to hide/show sideMenu
 showHideSubMenu(subMenu,mainMenuIcon);

