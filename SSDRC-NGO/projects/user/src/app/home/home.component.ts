import { Component, AfterViewInit, Inject, PLATFORM_ID } from '@angular/core';
import { isPlatformBrowser } from '@angular/common';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements AfterViewInit {

  private images = ['img1.jpg', 'img2.jpg', 'img3.jpg']; // Add more images as needed
  private currentImageIndex = 0;

  constructor(@Inject(PLATFORM_ID) private platformId: Object) {}

  ngAfterViewInit(): void {
    // Ensure the DOM is accessible only in the browser
    if (isPlatformBrowser(this.platformId)) {

      // Fade-in animations for elements with class 'fade-in'
      document.addEventListener('DOMContentLoaded', (): void => {
        const fadeInElements = document.querySelectorAll('.fade-in');
        fadeInElements.forEach(el => {
          const element = el as HTMLElement;
          element.style.opacity = '0';
          element.style.transform = 'translateY(20px)';
          setTimeout(() => {
            element.style.transition = 'opacity 1s ease, transform 1s ease';
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
          }, 100);
        });
      });

      // Smooth scroll to sections when links are clicked
      const links = document.querySelectorAll('a[href^="#"]');
      links.forEach(link => {
        link.addEventListener('click', e => {
          e.preventDefault();
          const href = link.getAttribute('href');
          if (href) {
            const target = document.querySelector(href);
            if (target) {
              target.scrollIntoView({ behavior: 'smooth' });
            }
          }
        });
      });

      // Change hero background image every 5 seconds
      this.changeHeroBackground();
    }
  }

  private changeHeroBackground(): void {
    setInterval(() => {
      const heroSection = document.querySelector('.hero') as HTMLElement;
      if (heroSection) {
        this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length;
        heroSection.style.backgroundImage = `url('/assets/img/${this.images[this.currentImageIndex]}')`;
      }
    }, 5000); // Change image every 5 seconds
  }
}