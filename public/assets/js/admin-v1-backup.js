document.addEventListener('DOMContentLoaded',function(){console.log('Admin UI ready')});
// Interactions: sidebar collapse, theme toggle
(function(){
 const root=document.documentElement;
 const body=document.body;
 const toggle=document.querySelector('.js-sidebar-toggle');
 const themeBtn=document.querySelector('.js-theme-toggle');
 const SIDEBAR='admin-sidebar-collapsed';
 const THEME='theme-dark';
 const set=(k,v)=>localStorage.setItem(k,v);
 const get=(k)=>localStorage.getItem(k);
 if(get('admin:collapsed')==='1') body.classList.add(SIDEBAR);
 if(get('admin:theme')==='dark') body.classList.add(THEME);
 toggle && toggle.addEventListener('click',function(){
  body.classList.toggle(SIDEBAR);
  set('admin:collapsed', body.classList.contains(SIDEBAR)?'1':'0');
 });
 themeBtn && themeBtn.addEventListener('click',function(){
  body.classList.toggle(THEME);
  set('admin:theme', body.classList.contains(THEME)?'dark':'light');
 });
})();