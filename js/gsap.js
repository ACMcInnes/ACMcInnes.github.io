document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(ScrollTrigger)
  // gsap code here!
  console.log(`GSAP loaded...`)
  let tl = gsap.timeline();
  tl.to(".rocket-yellow", {rotation: 360, x: 500, duration: 1})
    .to(".rocket-green", {rotation: 360, x: 200, duration: 2}, "-=0.75")
    .to(".rocket-blue", {rotation: 360, x: 700, duration: 1}, "+=1")
    .to(".rocket-purple", {rotation: 360, x: 400, duration: 2});
});
