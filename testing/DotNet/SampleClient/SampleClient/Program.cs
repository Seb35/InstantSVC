using System;
using System.Collections.Generic;
using System.Text;
using Microsoft.Web.Services3.Design;
using Microsoft.Web.Services3.Security.Tokens;

namespace SampleClient
{
    class Program
    {
        static void Main(string[] args)
        {
            TeleTaskService stub = new TeleTaskService();
            //Policy für die verwendung des UserName Token Profiles(UNTP) erstellen
            Policy policy = new Policy();
            policy.Assertions.Add(new UsernameOverTransportAssertion()); //User und Password gemäß UNTP mitschicken
            stub.SetPolicy(policy);
            //Token erstellen
            UsernameToken token = new UsernameToken("Micha", "HPI", PasswordOption.SendHashed);
            stub.SetClientCredential(token);

            Lecture[] lectures = stub.GetAllLectures();
            Console.WriteLine(lectures);

            Lecture lecture = stub.GetLecture(22);
            Console.WriteLine(lecture);

            lectures = stub.GetLecturesBySeries("Authentifizierung");
            Console.WriteLine(lectures);
        }
    }
}
