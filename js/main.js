// to close or open the nav button
const navItems = document.querySelector('.nav_items');
const openNavBtn = document.querySelector('#ope_nav_btn');
const closeNavBtn = document.querySelector('#close_nav_btn');

// opens nav menue dropdown
const openNav = ()=>{
    navItems.style.display='flex';
    openNavBtn.style.display='none';
    closeNavBtn.style.display='inline-block';
}

// close nav menue dropdown
const closeNav = ()=>{
    navItems.style.display='none';
    openNavBtn.style.display='inline-block';
    closeNavBtn.style.display='none';
}

openNavBtn.addEventListener('click',openNav);
closeNavBtn.addEventListener('click',closeNav);


const sidebar=document.querySelector('aside');
const showSidebarBtn = document.querySelector('#show_sidebar_btn');
const hideSidebarBtn = document.querySelector('#hide_sidebar_btn');


const showSidebar=()=>{
    sidebar.style.left='0';
    showSidebarBtn.style.display='none';
    hideSidebarBtn.style.display='inline-block';
}
const hideSidebar=()=>{
    sidebar.style.left= '-100%';
    showSidebarBtn.style.display = 'inline-block';
    hideSidebarBtn.style.display = 'none';
}

showSidebarBtn.addEventListener('click',showSidebar);
hideSidebarBtn.addEventListener('click',hideSidebar);