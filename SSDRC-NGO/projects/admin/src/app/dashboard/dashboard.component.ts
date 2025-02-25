import { Component } from '@angular/core';
import { SideBarComponent } from "../side-bar/side-bar.component";
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-dashboard',
  standalone: true,
  imports: [SideBarComponent, RouterModule],
  templateUrl: './dashboard.component.html',
  styleUrl: './dashboard.component.css'
})
export class DashboardComponent {

}
