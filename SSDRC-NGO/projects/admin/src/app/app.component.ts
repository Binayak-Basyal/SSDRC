import { LoginComponent } from "./login/login.component";
import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router'; 
import { SideBarComponent } from "./side-bar/side-bar.component";
import { DashboardComponent } from "./dashboard/dashboard.component";

@Component({
    selector: 'app-root',
    standalone: true,
    imports: [RouterOutlet], 
    templateUrl: './app.component.html',
    styleUrl: './app.component.css'
})
export class AppComponent {
    title = 'admin';
}