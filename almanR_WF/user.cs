using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace almanR
{
    internal class user
    {
        public string firstName { get; set; }
        public string lastName { get; set; }
        public string email { get; set; }
        public int role { get; set; }

        public user(string firstName, string lastName, string email, int role)
        {
            this.firstName = firstName;
            this.lastName = lastName;
            this.email = email;
            this.role = role;
        }
    }
}
