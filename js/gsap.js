document.addEventListener("DOMContentLoaded", (event) => {
  gsap.registerPlugin(ScrollTrigger, MotionPathPlugin)
  // gsap code here!
  console.log(`GSAP loaded...`)

  let tl = gsap.timeline();
  tl.to(".rocket-yellow", {rotation: 360, x: 300, duration: 1})
    .to(".rocket-green", {rotation: 360, x: 100, duration: 2}, "-=0.75")
    .to(".rocket-blue", {rotation: 360, x: 350, duration: 1}, "+=1")
    .to(".rocket-purple", {rotation: 360, x: 200, duration: 2});


 // Get the SVG path
const svg = document.querySelector("svg.line");
const triangle = document.querySelector(".triangle");
const lineSvgPath = document.querySelector("path.line-path");

gsap.set(svg, { opacity: 1 });
gsap.set(triangle, {
  scale: 1.5,
  autoAlpha: 1,
  transformOrigin: "50% 50%",
});

// Get the length of the line path for the stroke animation
const linePathLength = lineSvgPath.getTotalLength();

// Set up the stroke properties for the reveal animation
gsap.set(lineSvgPath, {
  strokeDasharray: linePathLength, // Ensure the dasharray covers the entire length of the path
  strokeDashoffset: linePathLength // Start with the stroke fully hidden (offset equal to the path length)
});

const dashLength = 5; // Length of each dash
const dotInterval = 22; // Set an interval for dash placement, 11

// Function to generate dashes along the path at regular intervals
function generateDashesAlongPath() {
  const totalLength = lineSvgPath.getTotalLength();

  // Loop through the path at specified intervals
  for (let i = 0; i < totalLength; i += dotInterval) {
    const point = lineSvgPath.getPointAtLength(i);
    const nextPoint = lineSvgPath.getPointAtLength(i + dashLength);

    // Create a "dash" element (a line) at the current position
    const trailDash = document.createElementNS("http://www.w3.org/2000/svg", "line");
    trailDash.setAttribute("x1", point.x); // Start of the dash
    trailDash.setAttribute("y1", point.y);
    trailDash.setAttribute("x2", nextPoint.x); // End of the dash
    trailDash.setAttribute("y2", nextPoint.y);
    trailDash.setAttribute("stroke-width", 1.5); // Width of the dash
    trailDash.classList.add("trail-dash"); // Initially hidden with CSS

    // Append the trail dash to the SVG
    svg.appendChild(trailDash);

    // Create a ScrollTrigger for each dash to toggle the class
    ScrollTrigger.create({
      trigger: trailDash,
      start: "top 70%",  // Trigger when the dash reaches the center of the viewport
      end: "center center",    // End at the same point
      onEnter: () => trailDash.classList.add("show"),        // Add the 'show' class on scroll down
      onLeaveBack: () => trailDash.classList.remove("show"), // Remove the 'show' class on scroll up
      scrub: true
    });
  }
}


// Select all .gsap-item elements
const gsapItems = document.querySelectorAll('.gsap-item');

// Add ScrollTrigger for each .gsap-item to reveal it at the center of the viewport
gsapItems.forEach((item, index, array) => {

  // trigger based off screen size
  let mm = gsap.matchMedia();

  mm.add("(min-width: 800px)", () => {
    // desktop sizes
    if (index === array.length -1) {
      // last trigger
      ScrollTrigger.create({
        trigger: item,
        start: "top 70%",  // Reveal when the center of the item reaches the center of the viewport
        end: "center center",    // End at the same point
        onEnter: () => {
          gsap.to(triangle, {
            scale: 10,
            duration: 1
          });
        }, // Scrolled down, expand spotlight
        onLeaveBack: () => {
          gsap.to(triangle, {
            scale: 1.5,
            duration: 1
          });
        }, // Scrolled back past, shrink spotlight
        scrub: true
      });
    } else {
      ScrollTrigger.create({
        trigger: item,
        start: "top 70%",  // Reveal when the center of the item reaches the center of the viewport
        end: "center center",    // End at the same point
        onEnter: () => {
          item.classList.add("show");
          gsap.to(triangle, {
            scale: 8,
            duration: 1
          });
        }, // Scrolled down, expand spotlight
        onLeave: () => {
          item.classList.remove("show");
          gsap.to(triangle, {
            scale: 1.5,
            duration: 1
          });
        }, // Scrolled down past, shrink spotlight
        onEnterBack: () => {
          item.classList.add("show");
          gsap.to(triangle, {
            scale: 8,
            duration: 1
          });
        }, // Scrolled back, expand spotlight
        onLeaveBack: () => {
          item.classList.remove("show");
          gsap.to(triangle, {
            scale: 1.5,
            duration: 1
          });
        }, // Scrolled back past, shrink spotlight
        scrub: true
      });
    }
  });

  mm.add("(max-width: 799px)", () => {
    // mobile sizes
    if (index === array.length -1) {
      // last trigger
      ScrollTrigger.create({
        trigger: item,
        start: "top 70%",  // Reveal when the center of the item reaches the center of the viewport
        end: "center center",    // End at the same point
        onEnter: () => {
          gsap.to(triangle, {
            scale: 5,
            duration: 1
          });
        }, // Scrolled down, expand spotlight
        onLeaveBack: () => {
          gsap.to(triangle, {
            scale: 1.5,
            duration: 1
          });
        }, // Scrolled back past, shrink spotlight
        scrub: true
      });
    } else {
      ScrollTrigger.create({
        trigger: item,
        start: "top 70%",  // Reveal when the center of the item reaches the center of the viewport
        end: "center center",    // End at the same point
        onEnter: () => {
          item.classList.add("show");
          gsap.to(triangle, {
            scale: 5,
            duration: 1
          });
        }, // Scrolled down, expand spotlight
        onLeave: () => {
          item.classList.remove("show");
          gsap.to(triangle, {
            scale: 1.5,
            duration: 1
          });
        }, // Scrolled down past, shrink spotlight
        onEnterBack: () => {
          item.classList.add("show");
          gsap.to(triangle, {
            scale: 5,
            duration: 1
          });
        }, // Scrolled back, expand spotlight
        onLeaveBack: () => {
          item.classList.remove("show");
          gsap.to(triangle, {
            scale: 1.5,
            duration: 1
          });
        }, // Scrolled back past, shrink spotlight
        scrub: true
      });
    }
  });

});

// Call the function to generate the dashes
generateDashesAlongPath();

let rotateTo = gsap.quickTo(triangle, "rotation"),
  prevDirection = 0;

  let lastProgress = 0; // Track the last progress to prevent backward motion

  gsap.to(triangle, {
    scrollTrigger: {
      trigger: lineSvgPath,
      start: "top 70%",
      end: () => "+=" + lineSvgPath.getBoundingClientRect().height,
      scrub: 0.5,
      markers: true,
      invalidateOnRefresh: true,
      onUpdate: (self) => {
        // Prevent triangle from moving backward on reverse scroll
        if (self.progress < lastProgress) {
          self.progress = lastProgress; // Lock the progress to prevent moving backward
        } else {
          lastProgress = self.progress; // Allow forward motion and update lastProgress
        }
        // console.log('Progress:', self.progress)
      }
    },
    ease: pathEase(lineSvgPath),
    immediateRender: true,
    motionPath: {
      path: lineSvgPath,
      align: lineSvgPath,
      alignOrigin: [0.5, 0.5],
      autoRotate: -90
    }
  });


/*
Helper function that returns an ease that bends time to ensure the target moves on the y axis in a relatively steady fashion in relation to the viewport (assuming the progress of the tween is linked linearly to the scroll position). Requires MotionPathPlugin of course.
*/
function pathEase(lineSvgPath, config = {}) {
  let axis = config.axis || "y",
    precision = config.precision || 1,
    rawPath = MotionPathPlugin.cacheRawPathMeasurements(MotionPathPlugin.getRawPath(gsap.utils.toArray(lineSvgPath)[0]), Math.round(precision * 12)),
    useX = axis === "x",
    start = rawPath[0][useX ? 0 : 1],
    end = rawPath[rawPath.length - 1][rawPath[rawPath.length - 1].length - (useX ? 2 : 1)],
    range = end - start,
    l = Math.round(precision * 200),
    inc = 1 / l,
    positions = [0],
    a = [],
    minIndex = 0,
    smooth = [0],
    minChange = (1 / l) * 0.6,
    smoothRange = config.smooth === true ? 7 : Math.round(config.smooth) || 0,
    fullSmoothRange = smoothRange * 2,
    getClosest = p => {
      while (positions[minIndex] <= p && minIndex++ < l) { }
      a.push((p - positions[minIndex - 1]) / (positions[minIndex] - positions[minIndex - 1]) * inc + minIndex * inc);
      smoothRange && a.length > smoothRange && (a[a.length - 1] - a[a.length - 2] < minChange) && smooth.push(a.length - smoothRange);
    },
    i = 1;
  for (; i < l; i++) {
    positions[i] = (MotionPathPlugin.getPositionOnPath(rawPath, i / l)[axis] - start) / range;
  }
  positions[l] = 1;
  for (i = 0; i < l; i++) {
    getClosest(i / l);
  }
  a.push(1); // must end at 1.
  if (smoothRange) {
    smooth.push(l - fullSmoothRange + 1);
    smooth.forEach(i => {
      let start = a[i],
        j = Math.min(i + fullSmoothRange, l),
        inc = (a[j] - start) / (j - i),
        c = 1;
      i++;
      for (; i < j; i++) {
        a[i] = start + inc * c++;
      }
    });
  }
  return p => {
    let i = p * l,
      s = a[i | 0];
    return i ? s + (a[Math.ceil(i)] - s) * (i % 1) : 0;
  };
}

    
/*
  gsap.to("#rocket", {
    scrollTrigger: {
      trigger: "#animate-path",
      pin: true,
      start: "top top",
      end: "bottom center",
      scrub: true,
      markers: true
    },
    motionPath: {
      path: "#animate-path",
      align: "#animate-path",
      alignOrigin: [0.5, 0.5],
      autoRotate: true
    },
    ease: "none"
  })
    */
});
