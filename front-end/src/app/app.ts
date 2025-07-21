import { Component  } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { AuthService } from './core/services/AuthService';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
   constructor(private auth: AuthService) {
    this.auth.loadCurrentUser();
   }

ngOnInit() {
  this.auth.getUser$().subscribe(user => {
    if (user) {
      console.log('👤 Utilisateur :', user.fullname, user.email);
    }
  });

  this.auth.isLoggedIn$().subscribe(isIn => {
    console.log('🔒 Connecté ?', isIn);
  });
}

}
