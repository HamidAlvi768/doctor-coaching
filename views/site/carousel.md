If your Bootstrap carousel is stuck on the 3rd slide and always snaps back to it-even when you try to move to another slide-there are a few common causes for this issue:

## Common Causes

**1. Multiple "active" Classes**
- The carousel requires that only one `.carousel-item` (or `.item` in Bootstrap 3) has the `active` class at any time. If more than one slide has `active`, the carousel can get confused and repeatedly jump back to the first `active` slide it finds, often causing the "stuck" behavior you're seeing[3].

**2. Mismatch Between Indicators and Slides**
- The number of carousel indicators (the dots or buttons for navigation) must match the number of slides. If you have, for example, 6 indicators but only 5 slides, or vice versa, navigation can break, and the carousel may get stuck or behave unpredictably[1].

**3. JavaScript or jQuery Errors**
- If there are JavaScript errors on the page, or if required libraries (like jQuery for Bootstrap 3/4) are missing or loaded in the wrong order, the carousel may not function properly[4][5]. Always check your browser's console for errors.

**4. Incorrect Data Attributes**
- For Bootstrap 5, the data attributes have changed (e.g., `data-bs-ride` instead of `data-ride`). Using the wrong attribute can prevent the carousel from working[5].

## How to Fix

- **Check for Multiple "active" Classes:**  
  Inspect your carousel items and ensure only one has the `active` class, typically the first slide[3].

- **Match Indicators and Slides:**  
  Make sure the number of `` elements in `.carousel-indicators` matches the number of `.carousel-item` elements[1].

- **Review JavaScript Console:**  
  Open your browser's developer tools and look for errors. Ensure jQuery (for Bootstrap 3/4) is loaded before Bootstrap's JS, and that all required scripts are present[4].

- **Verify Data Attributes:**  
  If using Bootstrap 5, use `data-bs-ride="carousel"` instead of `data-ride="carousel"`[5].

## Example: Correct Carousel Structure (Bootstrap 3)

```html

  
    
    
    
  
  
    
      
    
    
      
    
    
      
    
  
  

```
*Only the first `.item` should have `active`, and there should be three indicators for three slides.*

## Summary Table

| Issue                          | Effect                      | Solution                                       |
|---------------------------------|-----------------------------|------------------------------------------------|
| Multiple `active` classes       | Carousel gets stuck         | Only one `.item` has `active`                  |
| Indicator/slide count mismatch  | Navigation breaks           | Match indicator and slide counts               |
| JS/jQuery errors                | Carousel doesn't slide      | Check console, fix script order                |
| Wrong data attributes           | Carousel doesn't initialize | Use correct data attributes for Bootstrap ver. |

## References
- [Bootstrap carousel stuck on 3rd slide due to indicator/slide mismatch][1]
- [Active class should only be on one item][3]
- [Check JS errors and script order][4][5]

By checking these points, you should be able to resolve the issue of your Bootstrap carousel being stuck on the 3rd slide.